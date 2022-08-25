<?php

namespace App\Menu\UseCase;

use App\Models\Menu;

final class UpdateMenuUseCase
{
    /**
     *@return Menu
     */
    public function handle(Menu $menu, int $genre_id, string $menu_name): Menu
    {
        $menu->genre_id = $genre_id;
        $menu->name = $menu_name;
        $menu->save();

        return $menu;
    }
}
