<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

final class UpdateUserNameUseCase
{
    /**
     *
     */
    public function handle(string $name)
    {
        User::where('id', Auth::id())->update(['name' => $name]);
    }
}
