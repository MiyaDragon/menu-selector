<?php

namespace App\Menu\UseCase;

use App\Models\Menu;

final class DeleteMenuUseCase
{
    /**
     *@return Menu
     */
    public function handle(Menu $menu)
    {
        $menu->delete();
    }
}
