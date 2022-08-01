<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menus = $user->menus;
        return view('menus.index', ['menus' => $menus]);
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(MenuRequest $request, Menu $menu)
    {
        $user = $request->user();

        $genre = $user->genres->where('name', $request->genre_name)->first();

        if (empty($genre)) {
            $genre = new Genre();
            $genre->name = $request->genre_name;
            $genre->user_id = $user->id;
            $genre->save();
        };

        $menu->name = $request->menu_name;
        $menu->user_id = $user->id;
        $menu->genre_id = $genre->id;
        $menu->save();

        return redirect()->route('menus.create');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', ['menu' => $menu]);
    }

    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $user = $request->user();

        $genre = $user->genres->where('name', $request->genre_name)->first() ?? new Genre();

        $genre->name = $request->genre_name;
        $genre->user_id = $user->id;
        $genre->save();

        $menu->name = $request->menu_name;
        $menu->user_id = $user->id;
        $menu->genre_id = $genre->id;
        $menu->save();

        return redirect()->route('menus.index');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        if (Menu::where('genre_id', $menu->genre_id)->count() < 1) {
            Genre::destroy($menu->genre_id);
        }

        return redirect()->route('menus.index');
    }
}
