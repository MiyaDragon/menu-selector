<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

final class ShowMenuListPageUseCase
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $menus = Menu::where('user_id', Auth::id())
            ->whereNotNull('genre_id')->paginate(6);

        return [
            'menus' => $menus
        ];
    }
}
