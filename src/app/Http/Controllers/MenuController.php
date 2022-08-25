<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use App\Genre\UseCase\CreateGenreUseCase;
use App\Genre\UseCase\DeleteGenreUseCase;
use App\MenuImage\UseCase\CreateMenuImageUseCase;
use App\MenuImage\UseCase\DeleteMenuImageUseCase;
use App\Menu\UseCase\CreateMenuUseCase;
use App\Menu\UseCase\ShowMenuListPageUseCase;
use App\Menu\UseCase\ShowMenuCalendarPageUseCase;
use App\Menu\UseCase\UpdateMenuUseCase;
use App\Menu\UseCase\DeleteMenuUseCase;
use App\Menu\UseCase\CreateAteMenuUseCase;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
    }

    /**
     * 献立カレンダー表示
     */
    public function showMenuCalendar(Request $request, ShowMenuCalendarPageUseCase $useCase)
    {
        return view('menus.calendar', $useCase->handle($request->ym));
    }

    /**
     * メニュー一覧表示
     */
    public function index(ShowMenuListPageUseCase $useCase)
    {
        return view('menus.index', $useCase->handle());
    }

    /**
     * メニュー作成画面表示
     */
    public function create()
    {
        return view('menus.create');
    }

    /**
     * メニューを登録する
     */
    public function store(MenuRequest $request, CreateGenreUseCase $genreUseCase, CreateMenuImageUseCase $menuImageUseCase, CreateMenuUseCase $menuUseCase)
    {
        $genre = $genreUseCase->handle($request->genre_name);

        $menu = $menuUseCase->handle($genre->id, $request->menu_name);

        if (isset($request->menu_image)) {
            $menuImageUseCase->handle($request->file('menu_image'), $menu->id);
        };

        return redirect()->route('menus.create')->with('flash_message', '登録が完了しました。');
    }

    /**
     * メニュー編集画面表示
     */
    public function edit(Menu $menu)
    {
        return view('menus.edit', ['menu' => $menu]);
    }

    /**
     * メニューを更新する
     */
    public function update(MenuUpdateRequest $request, Menu $menu, CreateGenreUseCase $genreUseCase, CreateMenuImageUseCase $menuImageUseCase, UpdateMenuUseCase $menuUseCase)
    {
        $genre = $genreUseCase->handle($request->genre_name);

        $menu = $menuUseCase->handle($menu, $genre->id, $request->menu_name);

        if (isset($request->menu_image)) {
            $menuImageUseCase->handle($request->file('menu_image'), $menu);
        };

        return redirect()->route('menus.index')->with('flash_message', '更新しました。');
    }

    /**
     * メニューを削除する
     */
    public function destroy(Menu $menu, DeleteMenuUseCase $menuUseCase, DeleteGenreUseCase $genreUseCase, DeleteMenuImageUseCase $menuImageUseCase)
    {
        $menuUseCase->handle($menu);

        $genreUseCase->handle($menu);

        if (isset($menu->menu_image)) {
            $menuImageUseCase->handle($menu);
        }

        return redirect()->route('menus.index')->with('flash_message', '削除しました');
    }

    /**
     * 中間テーブルに食べた献立を登録
     */
    public function ateMenuStore(Request $request, CreateAteMenuUseCase $useCase)
    {
        $useCase->handle($request->menu);

        return redirect()->route('menus.calendar');
    }
}
