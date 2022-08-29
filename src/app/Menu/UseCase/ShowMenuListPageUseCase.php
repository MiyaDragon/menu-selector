<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\MenuImage\UseCase\MenuImageUrlUseCase;

final class ShowMenuListPageUseCase
{
    /**
     * ページ内に表示される内容
     * ・登録した献立の一覧
     * @return array
     */
    public function handle(): array
    {
        $menus = Menu::where('user_id', Auth::id())
            ->whereNotNull('genre_id')->paginate(6);

        $menu_image_urls = [];
        foreach($menus as $menu) {
            $menu_image_urls[$menu->id] = (new MenuImageUrlUseCase())->get($menu);
        }

        return [
            'menus' => $menus,
            'menu_image_urls' => $menu_image_urls,
        ];
    }
}
