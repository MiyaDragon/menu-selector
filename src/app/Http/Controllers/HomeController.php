<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $genres = Auth::user()->genres;
        } else {
            $genres = Genre::all()->unique('name');
        }

        return view('home', ['genres' => $genres]);
    }

    public function show(Request $request)
    {
        if ($request->genre_id === 'all') {
            $data = $this->getDataFromGenreAll();
        } else {
            $genre_id = $request->genre_id;
            $data = $this->getDataFromGenreDecided($genre_id);
        }

        return view('home', $data);
    }

    private function getDataFromGenreAll()
    {
        if (Auth::user()) {
            $menu = Auth::user()->menus->random();
            $genres = Auth::user()->genres;
        } else {
            $menu = Menu::all()->unique('name')->random();
            $genres = Genre::all()->unique('name');
        }

        $data = [
            'menu' => $menu,
            'genres' => $genres,
        ];

        return $data;
    }

    private function getDataFromGenreDecided(int $genre_id)
    {
        if (Auth::user()) {
            $menu = Auth::user()->menus->where('genre_id', $genre_id)->random();
            $genres = Auth::user()->genres;
        } else {
            $menu = Menu::where('genre_id', $genre_id)->get()->unique('name')->random();
            $genres = Genre::all()->unique('name');
        }

        $data = [
            'menu' => $menu,
            'genres' => $genres,
        ];

        return $data;
    }
}
