<?php

namespace App\Lib\RecipeCategories;

use Illuminate\Support\Collection;

interface RecipeCategoriesInterface
{
    public function get(): Collection;
}
