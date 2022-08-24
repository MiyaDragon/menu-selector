<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home\UseCase\ShowHomePageUseCase;
use App\Home\UseCase\ShowSelectedMenuPageUseCase;

class HomeController extends Controller
{
    /**
     * ホーム画面表示
     * @param ShowHomePageUseCase $useCase
     */
    public function index(ShowHomePageUseCase $useCase)
    {
        return view('home', $useCase->handle());
    }

    /**
     * ホーム画面に選択したメニュー表示
     * @param ShowSelectedMenuPageUseCase $useCase
     */
    public function show(Request $request, ShowSelectedMenuPageUseCase $useCase)
    {
        return view('home', $useCase->handle($request->genre_id));
    }
}
