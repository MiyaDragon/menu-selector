<?php

namespace App\MenuImage\UseCase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use App\Models\MenuImage;
use App\Models\Menu;

final class CreateMenuImageUseCase
{
    /**
     *
     */
    public function handle(UploadedFile $file, Menu $menu)
    {
        $tempPath = $this->createTempPath();

        Image::make($file)->fit(310, 230)->save($tempPath);

        $filePath = Storage::disk('s3')->putFile('images', new File($tempPath));

        if (isset($menu->menu_image)) {
            Storage::disk('s3')->delete($file);
            $menu_image = MenuImage::find($menu->menu_image->id);
            $menu_image->update([
                'path' => $filePath,
            ]);
        } else {
            $menu_image = MenuImage::create([
                'user_id' => Auth::id(),
                'path' => $filePath,
            ]);
        }

        $menu->menu_image_id = $menu_image->id;
        $menu->save();
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
}
