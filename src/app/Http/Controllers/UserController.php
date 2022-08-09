<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー情報更新画面表示
     */
    public function edit()
    {
        return view('users.edit', ['user' => Auth::user()]);
    }

    /**
     * ユーザー情報を更新する
     */
    public function update(UserRequest $request)
    {
        $user = User::where('id', Auth::id())
                    ->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);

        return redirect()->route('users.edit');
    }
    /**
     * ユーザー情報を論理削除する
     */
    public function destroy(User $user)
    {
        $user->delete();

        Auth::logout();

        return redirect(route('login'));
    }
}
