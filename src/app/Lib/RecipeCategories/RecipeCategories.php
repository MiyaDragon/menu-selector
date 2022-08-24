<?php

namespace App\Lib\RecipeCategories;

use App\Consts\ApiConst;
use RakutenRws_Client;

final class RecipeCategories implements RecipeCategoriesInterface
{
    /**
     * 楽天レシピAPIから献立のジャンルを取得
     * @return array
     */
    public function get(): array
    {
        $apiCategory = ApiConst::GENRES_API_CATEGORY;
        $param = ['categoryType' => ApiConst::GENRES_CATEGORY_TYPE];

        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $response = $client->execute($apiCategory, $param);

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
}
