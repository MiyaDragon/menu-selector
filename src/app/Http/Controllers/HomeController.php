<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // ToDo:ログイン中のユーザー＆選ばれたジャンルからメニューを一つ選び、返すようにする
        $menus = Menu::all();
        return view('home', ['menus' => $menus]);
    }
}
