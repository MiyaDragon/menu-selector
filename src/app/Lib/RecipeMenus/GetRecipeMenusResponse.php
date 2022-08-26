<?php

namespace App\Lib\RecipeMenus;

final class GetRecipeMenusResponse
{
    public string $name;
    public string $menu_image;
    public string $recipe_url;

    public function __construct(string $recipeTitle, string $foodImageUrl, string $recipeUrl)
    {
        $this->name = $recipeTitle;
        $this->menu_image = $foodImageUrl;
        $this->recipe_url = $recipeUrl;
    }
}
