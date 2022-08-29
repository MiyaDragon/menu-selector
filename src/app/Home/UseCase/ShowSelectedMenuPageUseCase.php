<?php

namespace App\Home\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Lib\RecipeMenus\RecipeMenusInterface;
use App\Lib\RecipeCategories\RecipeCategoriesInterface;
use App\MenuImage\UseCase\MenuImageUrlUseCase;
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
     * ・ゲストユーザー：
     * 楽天レシピAPIから取得した献立
     * 楽天レシピAPIから取得したジャンル
     * 楽天レシピAPIから取得した献立画像
     * 楽天レシピAPIから取得したレシピURL
     *
     * ・ログインユーザー：
     * 楽天レシピAPIから取得した献立＋自分で登録した献立
     * 楽天レシピAPIから取得したジャンル＋自分で登録したジャンル
     * 楽天レシピAPIから取得した献立画像 or 自分で登録した献立画像
     * 楽天レシピAPIから取得したレシピURL
     *
     * @param int|string $genre_id
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

    /**
     * ログインユーザーの処理
     * @param int|string $genre_id
     * @return array
     */
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
            $menu = $rakuten_menus->merge($menus)->random();
        } else {
            if (substr($genre_id, 0, 1) === ApiConst::RAKUTEN_PREFIX) {
                $menu = $this->menus->get(ltrim($genre_id, ApiConst::RAKUTEN_PREFIX))->random();
            } else {
                $menu = Auth::user()->menus->where('genre_id', $genre_id)->random();
            }
        }

        $data = [
            'menu' => $menu,
            'genres' => (new GetMixedGenresUseCase())->get($this->genres->get()),
            'menu_image_url' => (new MenuImageUrlUseCase())->get($menu),
            'recipe_url' => (new GetRecipeUrlUseCase())->get($menu),
        ];

        return $data;
    }

    /**
     * ゲストユーザーの処理
     * @param int|string $genre_id
     * @return array
     */
    private function getDataFromGuestUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $rand_num = $this->mt_rand_except(ApiConst::RAND_MIN,
            ApiConst::RAND_MAX, ApiConst::EXCEPT_NUMS);
            $menu = $this->menus->get($rand_num)->random();
        } else {
            $menu = $this->menus->get($genre_id)->random();
        }

        $data = [
            'menu' => $menu,
            'genres' => $this->genres->get(),
            'menu_image_url' => $menu->menu_image,
            'recipe_url' => $menu->recipe_url,
        ];

        return $data;
    }

    /**
     * ランダムな数字を生成
     * @param int $min
     * @param int $max
     * @param array|int $except
     * @return int
     */
    private function mt_rand_except(int $min, int $max, array|int $except): int
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
