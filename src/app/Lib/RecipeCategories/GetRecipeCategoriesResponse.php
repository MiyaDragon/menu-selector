<?php

namespace App\Lib\RecipeCategories;

final class GetRecipeCategoriesResponse
{
    public int $id;
    public string $name;

    public function __construct(int $categoryId, string $categoryName)
    {
        $this->id = $categoryId;
        $this->name = $categoryName;
    }
}
