<?php

namespace App\Home\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Lib\RecipeMenus\RecipeMenusInterface;
use App\Lib\RecipeCategories\RecipeCategoriesInterface;
use App\Consts\ApiConst;

final class ShowSelectedMenuPageUseCase
{
    private RecipeMenusInterface $menus;
    private RecipeCategoriesInterface $genres;

    public function __construct(RecipeMenusInterface $menus, RecipeCategoriesInterface $genres)
    {
        $this->menus = $menus;
        $this->genres = $genres;
    }

    /**
     * ページ内に表示される内容
     * ・ログイン前：
     * 楽天レシピAPIから取得した献立
     * 楽天レシピAPIから取得したジャンル
     * 楽天レシピAPIから取得した献立画像
     * 楽天レシピAPIから取得したレシピURL
     *
     * ・ログイン後：
     * 楽天レシピAPIから取得した献立＋自分で登録した献立
     * 楽天レシピAPIから取得したジャンル＋自分で登録したジャンル
     * 楽天レシピAPIから取得した献立画像 or 自分で登録した献立画像
     * 楽天レシピAPIから取得したレシピURL
     *
     * @return array
     */
    public function handle(int|string $genre_id): array
    {
        if (Auth::check()) {
            $data = $this->getDataFromAuthUser($genre_id);
        } else {
            $data = $this->getDataFromGuestUser($genre_id);
        }

        return $data;
    }

    private function getDataFromAuthUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $menus = Auth::user()->menus;
            $rand_num = $this->mt_rand_except(
                ApiConst::RAND_MIN,
                ApiConst::RAND_MAX,
                ApiConst::EXCEPT_NUMS
            );
            $rakuten_menus = $this->menus->get($rand_num);
            foreach ($rakuten_menus as $menu) {
                $menus = $menus->add($menu);
            }
            $menu = $menus->random();
        } else {
            if (substr($genre_id, 0, 1) === ApiConst::RAKUTEN_PREFIX) {
                $menus = $this->menus->get(ltrim($genre_id, ApiConst::RAKUTEN_PREFIX));
                $menu = collect($menus)->random();
            } else {
                $menu = Auth::user()->menus->where('genre_id', $genre_id)->random();
            }
        }

        $data = [
            'menu' => $menu,
            'genres' => (new GetMixedGenresUseCase())->get($this->genres->get()),
            'menu_image_url' => is_null($menu->menu_image) ? null : (new GetMenuImageUrlUseCase())->get($menu),
            'recipe_url' => (new GetRecipeUrlUseCase())->get($menu),
        ];

        return $data;
    }

    private function getDataFromGuestUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $rand_num = $this->mt_rand_except(ApiConst::RAND_MIN,
            ApiConst::RAND_MAX, ApiConst::EXCEPT_NUMS);
            $rakuten_menus = $this->menus->get($rand_num);
        } else {
            $rakuten_menus = $this->menus->get($genre_id);
        }

        $menu = collect($rakuten_menus)->random();

        $data = [
            'menu' => $menu,
            'genres' => $this->genres->get(),
            'menu_image_url' => $menu->menu_image,
            'recipe_url' => $menu->recipe_url,
        ];

        return $data;
    }

    private function mt_rand_except(int $min, int $max, $except): int
    {
        if (gettype($except) == 'array') {
            do {
                $num = mt_rand($min, $max);
            } while (in_array($num, $except));
        } else {
            do {
                $num = mt_rand($min, $max);
            } while ($num == $except);
        }

        return $num;
    }

}
