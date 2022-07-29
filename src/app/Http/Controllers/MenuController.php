<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\Genre;

class MenuController extends Controller
{
    public function create()
    {
        return view('menus.create');
    }

    public function store(MenuRequest $request)
    {
        $user = $request->user();

        $genre = Genre::firstOrCreate(['name' => $request->genre]);
        $menu = Menu::firstOrCreate(['name' => $request->name]);
        $user->genres()->syncWithoutDetaching($genre);
        $user->menus()->syncWithoutDetaching($menu);
        $menu->genres()->syncWithoutDetaching($genre);

        return redirect()->route('home');
    }

    public function delete(Request $request)
    {
        $menus = Menu::where('user_id', $request->user()->id)->get();

        return view('menus.delete', ['menus' => $menus]);
    }

    public function destroy(Request $request)
    {

        $menu = Menu::find($request->menu_id);

        $menu->delete();

        return redirect()->route('menus.delete');
    }
}
