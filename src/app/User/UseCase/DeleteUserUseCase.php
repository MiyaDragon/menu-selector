<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

final class DeleteUserUseCase
{
    /**
     *
     */
    public function handle(User $user)
    {
        $user->delete();

        Auth::logout();
    }
}
