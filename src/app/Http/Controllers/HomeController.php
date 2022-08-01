<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $user = Auth::user();
            $genres = $user->genres;
        } else {
            $genres = Genre::all();
        }

        return view('home', ['genres' => $genres]);
    }

    public function show(Request $request)
    {
        $user = Auth::user();
        if ($request->genre_id === 'all') {
            $menu = $user->menus->random();
        } else {
            $menu = $user->menus->where('genre_id', $request->genre_id)->random();
        }
        $genres = $user->genres;
        $data = [
            'genres' => $genres,
            'menu' => $menu,
        ];

        return view('home', $data);
    }
}
