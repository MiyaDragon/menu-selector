<?php

namespace App\Menu\UseCase;

use App\Models\Menu;

final class DeleteMenuUseCase
{
    /**
     * 登録されている献立を削除する
     * @param Menu $menu
     */
    public function handle(Menu $menu)
    {
        $menu->delete();
    }
}
