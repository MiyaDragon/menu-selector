<?php

namespace App\Genre\UseCase;

use App\Models\Menu;

final class DeleteGenreUseCase
{
    /**
     * 他の献立にジャンルが指定されてなければ、削除する
     * @param Menu $menu
     */
    public function handle(Menu $menu)
    {
        if ($this->isOtherGenreNotExists($menu)) {
            $menu->genre->delete();
        }
    }

    /**
     * 他の献立で、同じジャンルを指定しているのがあるか
     * @param Menu $menu
     * @return bool
     */
    private function isOtherGenreNotExists(Menu $menu): bool
    {
        return Menu::where('genre_id', $menu->genre_id)->doesntExist();
    }
}
