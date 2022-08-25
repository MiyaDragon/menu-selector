<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

final class UpdateUserEmailUseCase
{
    /**
     *
     */
    public function handle(string $email)
    {
        User::where('id', Auth::id())->update(['email' => $email]);
    }
}
