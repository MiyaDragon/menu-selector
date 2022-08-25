<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UpdateUserPasswordUseCase
{
    /**
     *
     */
    public function handle(string $password)
    {
        User::where('id', Auth::id())->update(['password' => Hash::make($password)]);
    }
}
