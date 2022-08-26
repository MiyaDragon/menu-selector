<?php

namespace App\Lib\RecipeCategories;

use Illuminate\Support\Collection;
use App\Consts\ApiConst;
use RakutenRws_Client;

final class RecipeCategories implements RecipeCategoriesInterface
{
    /**
     * 楽天レシピAPIから献立のジャンルを取得
     * @return Collection
     */
    public function get(): Collection
    {
        $apiCategory = ApiConst::GENRES_API_CATEGORY;
        $param = ['categoryType' => ApiConst::GENRES_CATEGORY_TYPE];

        $client = new RakutenRws_Client();
        $client->setApplicationId(config('app.rakuten_id'));
        $response = $client->execute($apiCategory, $param);

        if ($response->isOk()) {
            $genres = [];
            foreach ($response['result'][ApiConst::GENRES_CATEGORY_TYPE] as $rakutenItem) {
                $genres[] = new GetRecipeCategoriesResponse($rakutenItem['categoryId'], $rakutenItem['categoryName']);
            }
        } else {
            return 'Error:' . $response->getMessage();
        }

        return collect($genres);
    }
}
