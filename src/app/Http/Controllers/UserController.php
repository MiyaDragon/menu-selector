<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserNameUpdateRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\User\UseCase\UpdateUserNameUseCase;
use App\User\UseCase\UpdateEmailLinkUseCase;
use App\User\UseCase\UpdateUserEmailUseCase;
use App\User\UseCase\UpdateUserPasswordUseCase;
use App\User\UseCase\DeleteUserUseCase;

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
     * @param UserNameUpdateRequest $request
     * @param UpdateUserNameUseCase $useCase
     */
    public function updateName(UserNameUpdateRequest $request, UpdateUserNameUseCase $useCase)
    {
        $useCase->handle($request->name);

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
     * 新しいメールアドレスに、認証メールを送信する
     *
     * @param EmailUpdateRequest $request
     * @param UpdateEmailLinkUseCase $useCase
     */
    public function sendUpdateEmailLink(EmailUpdateRequest $request, UpdateEmailLinkUseCase $useCase)
    {
        $useCase->send($request->email);

        return redirect()->route('home')->with('flash_message', '確認メールを送信しました。');
    }

    /**
     * メールアドレスを更新する
     *
     * @param string $token
     * @param UpdateUserEmailUseCase $useCase
     */
    public function updateEmail(string $token, UpdateUserEmailUseCase $useCase)
    {
        $message = $useCase->handle($token);

        return redirect()->route('users.edit')->with($message['type'], $message['content']);
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
     * @param UserPasswordUpdateRequest $request
     * @param UpdateUserPasswordUseCase $useCase
     */
    public function updatePassword(UserPasswordUpdateRequest $request, UpdateUserPasswordUseCase $useCase)
    {
        $useCase->handle($request->password);

        return redirect()->route('users.edit')->with('flash_message', 'パスワードを変更しました。');
    }

    /**
     * ユーザー情報を削除する
     * @param User $user
     * @param DeleteUserUseCase $useCase
     */
    public function destroy(User $user, DeleteUserUseCase $useCase)
    {
        $useCase->handle($user);

        return redirect(route('login'));
    }
}
