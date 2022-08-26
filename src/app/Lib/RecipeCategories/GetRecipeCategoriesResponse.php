<?php

namespace App\Lib\RecipeCategories;

use App\Consts\ApiConst;

final class GetRecipeCategoriesResponse
{
    public string $id;
    public string $name;

    public function __construct(int $categoryId, string $categoryName)
    {
        $this->id = ApiConst::RAKUTEN_PREFIX . $categoryId;
        $this->name = $categoryName;
    }
}
