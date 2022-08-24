<?php

namespace App\Lib\RecipeMenus;

interface RecipeMenusInterface
{
    public function get(int $genre_id): array;
}
