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

    public function store(MenuRequest $request, Menu $menu, Genre $genre)
    {
        $genre_registed = Genre::where('name', $request->genre)->first();
        if (is_null($genre_registed)) {
            $genre->name = $request->genre;
            $genre->user_id = $request->user()->id;
            $genre->save();
        }
        #もっとスマートにしたい
        $genre = Genre::where('name', $request->genre)->first();
        $menu->name = $request->name;
        $menu->genre_id = $genre->id;
        $menu->user_id = $request->user()->id;
        $menu->save();

        return redirect()->route('home');
    }

    public function show(Request $request)
    {
        $menus = Menu::where('user_id', $request->user()->id)->get();

        return view('menus.show', ['menus' => $menus]);
    }

    public function destroy(Request $request)
    {

        $menu = Menu::find($request->menu_id);

        $menu->delete();

        return redirect()->route('menus.show');
    }
}
