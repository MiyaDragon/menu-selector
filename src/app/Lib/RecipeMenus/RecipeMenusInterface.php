<?php

namespace App\Lib\RecipeMenus;

use Illuminate\Support\Collection;

interface RecipeMenusInterface
{
    public function get(int $genre_id): Collection;
}
