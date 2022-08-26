<?php

namespace App\MenuImage\UseCase;

use Illuminate\Support\Facades\Storage;
use App\Models\Menu;

final class DeleteMenuImageUseCase
{
    /**
     * S3とDBから登録されている献立画像を削除する
     * @param Menu $menu
     */
    public function handle(Menu $menu)
    {
        Storage::disk('s3')->delete($menu->menu_image->path);
        $menu->menu_image->delete();
    }
}
