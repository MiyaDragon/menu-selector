<?php

namespace App\Genre\UseCase;

use App\Models\Menu;

final class DeleteGenreUseCase
{
    /**
     * @return
     */
    public function handle(Menu $menu)
    {
        if ($this->isOtherGenreNotExists($menu)) {
            $menu->genre->delete();
        }
    }

    /**
     * 他のメニューで、同じジャンルを指定しているのがあるか
     */
    private function isOtherGenreNotExists(Menu $menu): bool
    {
        return Menu::where('genre_id', $menu->genre_id)->doesntExist();
    }
}
