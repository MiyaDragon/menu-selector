<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $genres = Genre::where('user_id', Auth::id())->get();
        } else {
            $genres = Genre::all();
        }
        $data = [
            'genres' => $genres,
            'menu' => '今日の献立は...',
        ];
        return view('home', $data);
    }

    public function show(Request $request)
    {
        if ($request->genre_id === 'all') {
            $menu = Menu::inRandomOrder()
                ->get()
                ->where('user_id', Auth::id())
                ->first();
        } else {
            $menu = Menu::inRandomOrder()
                ->get()
                ->where('genre_id', $request->genre_id)
                ->first();
        }
        $genres = Genre::where('user_id', Auth::id())->get();
        $data = [
            'genres' => $genres,
            'menu' => $menu->name,
        ];

        return view('home', $data);
    }
}
