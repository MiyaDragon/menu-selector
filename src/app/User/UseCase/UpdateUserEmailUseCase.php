<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

final class UpdateUserEmailUseCase
{
    /**
     * メールアドレスを更新する
     * @param string $email
     */
    public function handle(string $email)
    {
        User::where('id', Auth::id())->update(['email' => $email]);
    }
}
