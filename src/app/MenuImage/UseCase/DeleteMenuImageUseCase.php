<?php

namespace App\MenuImage\UseCase;

use Illuminate\Support\Facades\Storage;
use App\Models\Menu;

final class DeleteMenuImageUseCase
{
    /**
     *
     */
    public function handle(Menu $menu)
    {
        Storage::disk('s3')->delete($menu->menu_image->path);
        $menu->menu_image->delete();
    }
}
