<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        // return view('users.edit', ['user' => $user]);
        return view('users.edit');
    }

    public function update()
    {
    }
}
