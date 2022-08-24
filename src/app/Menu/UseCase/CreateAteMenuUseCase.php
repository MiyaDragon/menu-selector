<?php

namespace App\Menu\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Lib\Genres\GenresInterface;
use App\Models\Menu;
use App\Models\MenuImage;
use App\Models\RecipeUrl;
use Carbon\Carbon;

final class CreateAteMenuUseCase
{
    private GenresInterface $genres;

    public function __construct(GenresInterface $genres)
    {
        $this->genres = $genres;
    }

    /**
     * 中間テーブルに食べた献立を登録
     */
    public function handle(Request $request)
    {
        // 同じ日付で登録されているか
        $ate_menus = Auth::user()->ate_menus;

        foreach ($ate_menus as $menu) {
            if ($menu->pivot->created_at == new Carbon(today())) {
                return redirect()->route('menus.calendar')
                ->with('error_message', '本日の献立は既に登録されています');
            }
        }

        $menu_id = $request->menu;

        if (is_array($request->menu)) {
            $menu_image = new MenuImage();
            $menu_image->user_id = Auth::id();
            $menu_image->path = $request->menu['menu_image'];
            $menu_image->save();

            $recipe_url = new RecipeUrl();
            $recipe_url->user_id = Auth::id();
            $recipe_url->url = $request->menu['recipe_url'];
            $recipe_url->save();

            $menu = new Menu();
            $menu->user_id = Auth::id();
            $menu->menu_image_id = $menu_image->id;
            $menu->recipe_url_id = $recipe_url->id;
            $menu->name = $request->menu['name'];
            $menu->save();

            $menu_id = $menu->id;
        }

        Menu::find($menu_id)->ate_menus()->attach(Auth::id());
    }
}
