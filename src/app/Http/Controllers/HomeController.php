<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            $genres = $useCase->handle();
        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->route('home')->with('error_message', '処理に失敗しました。再度実行ください。');
        }
        return view('home', $genres);
    }

    /**
     * ホーム画面に選択したメニュー表示
     * @param ShowSelectedMenuPageUseCase $useCase
     */
    public function show(Request $request, ShowSelectedMenuPageUseCase $useCase)
    {
        try {
            $data = $useCase->handle($request->genre_id);
        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->route('home')->with('error_message', '処理に失敗しました。再度実行ください。');
        }
        return view('show', $data);
    }
}
