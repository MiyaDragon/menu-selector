<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use App\Models\Genre;
use App\Models\MenuImage;
use App\Models\RecipeUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Menu::class, 'menu');
    }

    /**
     * 献立カレンダー表示
     */
    public function calendar(Request $request, Carbon $dt)
    {
        $year = $request->ym ? mb_substr($request->ym, 0, 4) : $dt->year;
        $month = $request->ym ? mb_substr($request->ym, 5) : $dt->month;

        $current_date = new Carbon("{$year}-{$month}-1");

        $dates = $this->getCalendarDates($year, $month);

        $menus = Auth::user()->ate_menus;

        return view('menus.calendar', ['menus' => $menus, 'dates' => $dates, 'current_dates' => $current_date]);
    }

    /**
     * カレンダーに表示する日数を取得
     */
    private function getCalendarDates(int $year, int $month): array
    {
        $date = new Carbon("{$year}-{$month}-01");

        $addDay = ($date->copy()->endOfMonth()->isSunday() || $date->dayOfWeek == 6) ? 7 : 0;

        $date->subDay($date->dayOfWeek);

        $count = 31 + $addDay + $date->dayOfWeek;
        $count = ceil($count / 7) * 7;

        $dates = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $dates[] = $date->copy();
        }

        return $dates;
    }

    /**
     * メニュー一覧表示
     */
    public function index()
    {
        $menus = Menu::where('user_id', Auth::id())
            ->whereNotNull('genre_id')->paginate(6);

        return view('menus.index', ['menus' => $menus]);
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
    public function store(MenuRequest $request, Menu $menu, MenuImage $menu_image)
    {
        $genre = $this->getGenre($request->genre_name);
        if (empty($genre)) {
            $genre = $this->createGenre($request->genre_name);
        };

        if (isset($request->menu_image)) {
            $menu_image = $this->createMenuImage($menu_image, $request->file('menu_image'));
            $menu->menu_image_id = $menu_image->id;
        };

        $menu->user_id = Auth::id();
        $menu->genre_id = $genre->id;
        $menu->name = $request->menu_name;
        $menu->save();

        return redirect()->route('menus.create')->with('flash_message', '登録が完了しました');
    }

    /**
     * ジャンルが既に登録されている場合、取得する
     */
    private function getGenre(string $genre_name): Genre|null
    {
        return Auth::user()->genres->where('name', $genre_name)->first();
    }

    /**
     * ジャンルを登録する
     */
    private function createGenre(string $genre_name): Genre
    {
        $genre = Genre::create([
            'name' => $genre_name,
            'user_id' => Auth::id(),
        ]);

        return $genre;
    }

    /**
     * メニュー画像を登録する
     */
    private function createMenuImage(MenuImage $menu_image, string $file): MenuImage
    {
        $tempPath = $this->createTempPath();

        Image::make($file)->fit(310, 230)->save($tempPath);

        $filePath = Storage::disk('s3')->putFile('images', new File($tempPath));

        $menu_image->user_id = Auth::id();
        $menu_image->path = $filePath;
        $menu_image->save();

        return $menu_image;
    }

    /**
     * 画像を一時保管ファイルを作成し、パスを返す
     */
    private function createTempPath(): string
    {
        $tmp_fp = tmpfile();
        $meta   = stream_get_meta_data($tmp_fp);

        return $meta["uri"];
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
    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $genre = $this->getGenre($request->genre_name);
        if (empty($genre)) {
            $genre = $this->createGenre($request->genre_name);
        };

        if (isset($request->menu_image)) {
            Storage::disk('s3')->delete($request->file('menu_image'));
            $menu_image = $this->findMenuImage($menu, new MenuImage());
            $menu_image = $this->createMenuImage($menu_image, $request->file('menu_image'));
            $menu->menu_image_id = $menu_image->id;
        };

        $menu->name = $request->menu_name;
        $menu->genre_id = $genre->id;
        $menu->save();

        return redirect()->route('menus.index')->with('flash_message', '更新しました');
    }

    /**
     * メニュー画像が登録されていれば、該当するインスタンスを返す
     */
    private function findMenuImage(Menu $menu, MenuImage $menu_image): MenuImage
    {
        if (isset($menu->menu_image)) {
            $menu_image = MenuImage::find($menu->menu_image->id);
        }

        return $menu_image;
    }

    /**
     * メニューを削除する
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        if ($this->isOtherGenreNotExists($menu)) {
            $menu->genre->delete();
        }

        if (isset($menu->menu_image)) {
            Storage::disk('s3')->delete($menu->menu_image->path);
            $menu->menu_image->delete();
        }

        return redirect()->route('menus.index')->with('flash_message', '削除しました');
    }

    /**
     * 他のメニューで、同じジャンルを指定しているのがあるか
     */
    private function isOtherGenreNotExists(Menu $menu): bool
    {
        return Menu::where('genre_id', $menu->genre_id)->doesntExist();
    }

    /**
     * 中間テーブルに食べた献立を登録
     */
    public function ateMenuCreate(Request $request)
    {
        // 同じ日付で登録されているか
        $ate_menus = Auth::user()->ate_menus;

        foreach ($ate_menus as $menu) {
            if ($menu->pivot->created_at == new Carbon(today())) {
                return redirect()->route('menus.calendar')
                        ->with('error_message', '本日の献立は既に登録されています');
            }
        }

        $menu_id = $request->menu;

        if (is_array($request->menu)) {
            $menu_image = new MenuImage();
            $menu_image->user_id = Auth::id();
            $menu_image->path = $request->menu['menu_image'];
            $menu_image->save();

            $recipe_url = new RecipeUrl();
            $recipe_url->user_id = Auth::id();
            $recipe_url->url = $request->menu['recipe_url'];
            $recipe_url->save();

            $menu = new Menu();
            $menu->user_id = Auth::id();
            $menu->menu_image_id = $menu_image->id;
            $menu->recipe_url_id = $recipe_url->id;
            $menu->name = $request->menu['name'];
            $menu->save();

            $menu_id = $menu->id;
        }

        Menu::find($menu_id)->ate_menus()->attach(Auth::id());
    }
}
