<?php

namespace App\Home\UseCase;

use App\Models\Menu;

final class GetRecipeUrlUseCase
{
    /**
     * 献立レシピURLを取得
     * @return string|null
     */
    public function get(Object $menu): string | null
    {
        if ($menu instanceof (new Menu())) {
            if (isset($menu->recipe_url_id)) {
                return $menu->recipe_url->url;
            } else {
                return null;
            }
        }

        return $menu->recipe_url;
    }
}
