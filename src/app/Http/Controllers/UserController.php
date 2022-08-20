<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
     * ユーザー名更新画面表示
     */
    public function editName()
    {
        return view('users.edit_name', ['user' => Auth::user()]);
    }

    /**
     * ユーザー名を更新する
     */
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);

        User::where('id', Auth::id())->update(['name' => $request->name]);

        return redirect()->route('users.edit')->with('flash_message', 'ユーザー名を変更しました。');
    }
    /**
     * メールアドレス更新画面表示
     */
    public function editEmail()
    {
        return view('users.edit_email', ['user' => Auth::user()]);
    }

    /**
     * メールアドレスを更新する
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)]
        ]);

        User::where('id', Auth::id())->update(['email' => $request->email]);

        return redirect()->route('users.edit')->with('flash_message', 'メールアドレスを変更しました。');
    }
    /**
     * パスワード更新画面表示
     */
    public function editPassword()
    {
        return view('users.edit_password', ['user' => Auth::user()]);
    }

    /**
     * パスワードを更新する
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8', 'string'],
        ]);

        User::where('id', Auth::id())->update(['password' => Hash::make($request->password)]);

        return redirect()->route('users.edit')->with('flash_message', 'パスワードを変更しました。');
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
