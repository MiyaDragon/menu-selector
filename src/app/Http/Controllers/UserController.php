<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function show()
    // {
    //     return view('users.show');
    // }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request)
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

        return redirect()->route('users.edit');
    }
}
