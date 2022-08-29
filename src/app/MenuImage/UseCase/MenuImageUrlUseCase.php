<?php

namespace App\MenuImage\UseCase;

use App\Models\Menu;

final class MenuImageUrlUseCase
{
    /**
     * 献立画像を取得
     * @param Object $menu
     * @return string|null
     */
    public function get(Object $menu): string|null
    {
        if (is_null($menu->menu_image)) {
            return null;
        }else {
            if ($menu instanceof (new Menu())) {
                if (isset($menu->genre_id)) {
                    $useCase = new PresigneUrlUseCase();
                    return $useCase->get($menu->menu_image->path);
                } else {
                    return $menu->menu_image->path;
                }
            }
        }

        return $menu->menu_image;
    }
}
