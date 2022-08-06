<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Menu;
use App\Models\Genre;
use App\Models\MenuImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;

class MenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $menus = $user->menus;
        return view('menus.index', ['menus' => $menus]);
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(MenuRequest $request, Menu $menu, MenuImage $menu_image)
    {
        $user = $request->user();

        $genre = $user->genres->where('name', $request->genre_name)->first();
        if (empty($genre)) {
            $genre = new Genre();
            $genre->name = $request->genre_name;
            $genre->user_id = $user->id;
            $genre->save();
        };

        if (!empty($request->menu_image)) {
            $file = $request->file('menu_image');

            $tempPath = $this->makeTempPath();

            Image::make($file)->fit(310, 230)->save($tempPath);

            $filePath = Storage::disk('s3')->putFile('test', new File($tempPath));
            $menu_image->user_id = $user->id;
            $menu_image->path = $filePath;
            $menu_image->save();
            $menu->menu_image_id = $menu_image->id;
        };

        $menu->user_id = $user->id;
        $menu->genre_id = $genre->id;
        $menu->name = $request->menu_name;
        $menu->save();

        return redirect()->route('menus.create');
    }

    private function makeTempPath(): string
    {
        $tmp_fp = tmpfile();
        $meta   = stream_get_meta_data($tmp_fp);
        return $meta["uri"];
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', ['menu' => $menu]);
    }

    public function update(MenuUpdateRequest $request, Menu $menu)
    {
        $user = $request->user();

        $genre = $user->genres->where('name', $request->genre_name)->first() ?? new Genre();
        $genre->name = $request->genre_name;
        $genre->user_id = $user->id;
        $genre->save();

        if (!empty($request->menu_image)) {
            Storage::disk('s3')->delete($request->file('menu_image'));
            $menu_image = MenuImage::find($menu->menu_image->id);
            $path = Storage::disk('s3')->putFile('/images', $request->file('menu_image'));
            $menu_image->path = $path;
            $menu_image->save();
        }

        $menu->name = $request->menu_name;
        $menu->genre_id = $genre->id;
        $menu->save();

        return redirect()->route('menus.index');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        if (Menu::where('genre_id', $menu->genre_id)->count() < 1) {
            $menu->genre->delete();
        }

        if (isset($menu->menu_image)) {
            Storage::disk('s3')->delete($menu->menu_image->path);
            $menu->menu_image->delete();
        }

        return redirect()->route('menus.index');
    }
}
