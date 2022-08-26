<?php

namespace App\Home\UseCase;

use App\Models\Menu;

final class GetMenuImageUrlUseCase
{
    /**
     * 献立画像を取得
     * @param Object $menu
     * @return string
     */
    public function get(Object $menu): string
    {
        if ($menu instanceof (new Menu())) {
            if (isset($menu->genre_id)) {
                return $menu->menu_image->getPresignedUrl();
            } else {
                return $menu->menu_image->path;
            }
        }

        return $menu->menu_image;
    }
}
