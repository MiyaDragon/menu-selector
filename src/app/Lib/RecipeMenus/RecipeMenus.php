<?php

namespace App\Lib\RecipeMenus;

use Illuminate\Support\Collection;
use App\Consts\ApiConst;
use RakutenRws_Client;

final class RecipeMenus implements RecipeMenusInterface
{
    /**
     * 楽天レシピAPIから献立のジャンルを取得
     * @param int $genre_id
     * @return Collection
     */
    public function get(int $genre_id): Collection
    {
        $apiCategory = ApiConst::MENUS_API_CATEGORY;
        $param = ['categoryId' => $genre_id];

        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $response = $client->execute($apiCategory, $param);

        if ($response->isOk()) {
            $menus = [];
            foreach ($response['result'] as $rakutenItem) {
                $menus[] = new GetRecipeMenusResponse($rakutenItem['recipeTitle'], $rakutenItem['foodImageUrl'], $rakutenItem['recipeUrl']);
            }
        } else {
            return 'Error:' . $response->getMessage();
        }

        return collect($menus);
    }
}
