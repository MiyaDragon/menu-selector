<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

final class CreateMenuUseCase
{
    /**
     *@return Menu
     */
    public function handle(int $genre_id, string $menu_name): Menu
    {
        $menu = Menu::create([
            'user_id' => Auth::id(),
            'genre_id' => $genre_id,
            'name' => $menu_name,
        ]);

        return $menu;
    }
}
