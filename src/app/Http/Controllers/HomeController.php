<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RakutenRws_Client;
use App\Consts\ApiConst;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->client = new RakutenRws_Client();
        $this->client->setApplicationId(config('app.rakuten_id'));
    }
    /**
     * ホーム画面表示
     */
    public function index()
    {
        if (Auth::check()) {
            $genres = $this->getMixGenres();
        } else {
            $genres = $this->getRakutenGenres();
        }

        return view('home', ['genres' => $genres]);
    }

    /**
     * 登録済みのジャンルと楽天レシピAPIから取得したジャンルを結合
     */
    private function getMixGenres(): Collection
    {
        $genres = Auth::user()->genres;
        $rakuten_genres = $this->getRakutenGenres();
        foreach ($rakuten_genres as $genre) {
            $genres = $genres->add($genre);
        }

        return $genres;
    }

    /**
     * 楽天レシピAPIから献立のジャンルを取得
     */
    private function getRakutenGenres()
    {
        $apiCategory = ApiConst::GENRES_API_CATEGORY;
        $param = ['categoryType' => ApiConst::GENRES_CATEGORY_TYPE];

        $response = $this->getResponse($apiCategory, $param);

        if ($response->isOk()) {
            $genres = [];
            foreach ($response['result'][ApiConst::GENRES_CATEGORY_TYPE] as $rakutenItem) {
                $genres[] = (object) array(
                    'id' => ApiConst::RAKUTEN_PREFIX . $rakutenItem['categoryId'],
                    'name' => $rakutenItem['categoryName'],
                );
            }
        } else {
            return 'Error:' . $response->getMessage();
        }

        return $genres;
    }

    /**
     * 楽天レシピAPIからレスポンスを取得
     */
    private function getResponse(string $apiCategory, array $param)
    {
        return $this->client->execute($apiCategory, $param);
    }

    /**
     * ホーム画面表示（メニュー表示あり）
     */
    public function show(Request $request)
    {
        if (Auth::check()) {
            $data = $this->getDataFromAuthUser($request->genre_id);
        } else {
            $data = $this->getDataFromGuestUser($request->genre_id);
        }
        return view('home', $data);
    }

    private function getDataFromAuthUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $menus = $this->getMixMenus();
            $menu = $menus->random();
        } else {
            if (substr($genre_id, 0, 1) === ApiConst::RAKUTEN_PREFIX) {
                $menus = $this->getRakutenMenus(ltrim($genre_id, ApiConst::RAKUTEN_PREFIX));
                $menu = collect($menus)->random();
            } else {
                $menu = Auth::user()->menus->where('genre_id', $genre_id)->random();
            }
        }

        $data = [
            'menu' => $menu,
            'genres' => $this->getMixGenres(),
            'menu_image_url' => is_null($menu->menu_image) ? null : $this->getMenuImageUrl($menu),
        ];

        return $data;
    }

    /**
     * 登録済みの献立と楽天レシピAPIから取得した献立を結合
     */
    // private function getMixMenus()
    private function getMixMenus(): Collection
    {
        $menus = Auth::user()->menus;
        $rand_num = $this->mt_rand_except(ApiConst::RAND_MIN, ApiConst::RAND_MAX, ApiConst::EXCEPT_NUMS);
        $rakuten_menus = $this->getRakutenMenus($rand_num);
        foreach ($rakuten_menus as $menu) {
            $menus = $menus->add($menu);
        }
        return $menus;
    }

    private function getMenuImageUrl(Object $menu): string
    {
        if (is_object($menu->menu_image)) {
            return $menu->menu_image->getPresignedUrl();
        }

        return $menu->menu_image;
    }

    private function getDataFromGuestUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $rand_num = $this->mt_rand_except(ApiConst::RAND_MIN, ApiConst::RAND_MAX, ApiConst::EXCEPT_NUMS);
            $menus = $this->getRakutenMenus($rand_num);
        } else {
            $menus = $this->getRakutenMenus($genre_id);
        }

        $menu = collect($menus)->random();

        $data = [
            'menu' => $menu,
            'genres' => $this->getRakutenGenre(),
            'menu_url' => $menu->menu_image,
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

    /**
     * 楽天レシピAPIから献立名を取得
     */
    private function getRakutenMenus(int $genre_id)
    {
        $apiCategory = ApiConst::MENUS_API_CATEGORY;
        $param = ['categoryId' => $genre_id];

        $response = $this->getResponse($apiCategory, $param);

        if ($response->isOk()) {
            $menus = [];
            foreach ($response['result'] as $rakutenItem) {
                $menus[] = (object) array(
                    'name' => $rakutenItem['recipeTitle'],
                    'menu_image' => $rakutenItem['foodImageUrl'],
                    'recipe_url' => $rakutenItem['recipeUrl'],
                );
            }
        } else {
            return 'Error:' . $response->getMessage();
        }

        return $menus;
    }
}
