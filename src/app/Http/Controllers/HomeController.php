<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * ホーム画面表示
     */
    public function index()
    {
        if (Auth::check()) {
            $genres = Auth::user()->genres;
        } else {
            $genres = Genre::all()->unique('name');
        }

        return view('home', ['genres' => $genres]);
    }

    /**
     * ホーム画面表示（メニュー表示あり）
     */
    public function show(Request $request)
    {
        if (Auth::check()) {
            $data = $this->getDataFromAuthUser($request->genre_id);
        } else {
            $data = $this->getDataFromGuestUser($request->genre_id);
        }

        return view('home', $data);
    }

    private function getDataFromAuthUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $menu = Auth::user()->menus->random();
        } else {
            $menu = Auth::user()->menus->where('genre_id', $genre_id)->random();
        }

        $data = [
            'menu' => $menu,
            'genres' => Auth::user()->genres,
        ];

        return $data;
    }

    private function getDataFromGuestUser(int|string $genre_id): array
    {
        if ($genre_id === 'all') {
            $menu = Menu::all()->unique('name')->random();
        } else {
            $menu = Menu::where('genre_id', $genre_id)->get()->unique('name')->random();
        }

        $data = [
            'menu' => $menu,
            'genres' => Genre::all()->unique('name'),
        ];

        return $data;
    }
}
