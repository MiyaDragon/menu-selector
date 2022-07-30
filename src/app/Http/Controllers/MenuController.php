<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
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

    public function index()
    {
        $user = Auth::user();
        $menus = $user->menus;
        return view('menus.index', ['menus' => $menus]);
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', ['menu' => $menu]);
    }

    public function update(MenuRequest $request, Menu $menu)
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

        $menus = $user->menus;

        return redirect()->route('menus.index', ['menus' => $menus]);
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
