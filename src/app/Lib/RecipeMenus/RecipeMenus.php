<?php

namespace App\Lib\RecipeMenus;

use App\Consts\ApiConst;
use RakutenRws_Client;

final class RecipeMenus implements RecipeMenusInterface
{
    /**
     * 楽天レシピAPIから献立のジャンルを取得
     * @return array
     */
    public function get(int $genre_id): array
    {
        $apiCategory = ApiConst::MENUS_API_CATEGORY;
        $param = ['categoryId' => $genre_id];

        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $response = $client->execute($apiCategory, $param);

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
