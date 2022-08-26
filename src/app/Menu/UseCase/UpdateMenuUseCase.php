<?php

namespace App\Menu\UseCase;

use App\Models\Menu;

final class UpdateMenuUseCase
{
    /**
     *
     * 登録されている献立の内容を更新する
     *
     * @param Menu $menu
     * @param int $genre_id
     * @param string $menu_name
     * @return Menu
     */
    public function handle(Menu $menu, int $genre_id, string $menu_name): Menu
    {
        $menu->genre_id = $genre_id;
        $menu->name = $menu_name;
        $menu->save();

        return $menu;
    }
}
