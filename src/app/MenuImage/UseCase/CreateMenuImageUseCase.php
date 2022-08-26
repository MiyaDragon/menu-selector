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
     * ・新規で献立画像を登録する場合
     * 送られてきたfileをS3とDBに登録する
     *
     * ・献立画像を更新する場合
     * 既にS3に登録されている画像を削除し、S3とDBに登録する
     *
     * @param UploadedFile $file
     * @param Menu $menu
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
     * @return string
     */
    private function createTempPath(): string
    {
        $tmp_fp = tmpfile();
        $meta   = stream_get_meta_data($tmp_fp);

        return $meta["uri"];
    }
}
