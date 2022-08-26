<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

final class UpdateUserNameUseCase
{
    /**
     * ユーザー名を更新する
     * @param string $name
     */
    public function handle(string $name)
    {
        User::where('id', Auth::id())->update(['name' => $name]);
    }
}
