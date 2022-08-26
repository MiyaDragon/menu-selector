<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\MenuImage;
use App\Models\RecipeUrl;
use Carbon\Carbon;

final class CreateAteMenuUseCase
{
    /**
     * 中間テーブルに食べた献立を登録
     * @param int|array $menu
     */
    public function handle(int|array $menu)
    {
        // 同じ日付で登録されているか
        $ate_menus = Auth::user()->ate_menus;

        foreach ($ate_menus as $ate_menu) {
            if ($ate_menu->pivot->created_at == new Carbon(today())) {
                return redirect()->route('menus.calendar')
                ->with('error_message', '本日の献立は既に登録されています');
            }
        }

        if (is_array($menu)) {
            $menu_image = MenuImage::create([
                'user_id' => Auth::id(),
                'path' => $menu['menu_image'],
            ]);

            $recipe_url = RecipeUrl::create([
                'user_id' => Auth::id(),
                'url' => $menu['recipe_url'],
            ]);

            $menu = Menu::create([
                'user_id' => Auth::id(),
                'menu_image_id' => $menu_image->id,
                'recipe_url_id' => $recipe_url->id,
                'name' => $menu['name'],
            ]);

            Menu::find($menu->id)->ate_menus()->attach(Auth::id());
        }else {
            Menu::find($menu)->ate_menus()->attach(Auth::id());
        }
    }
}
