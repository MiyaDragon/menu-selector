<?php

namespace App\User\UseCase;

use App\Models\User;
use App\Models\EmailReset;
use Carbon\Carbon;

final class UpdateUserEmailUseCase
{
    /**
     * トークンが存在している、かつ、有効期限が切れていない
     * ・メールアドレスを更新する
     * ・EmailRestモデルのレコードを削除
     * トークンが存在していない、もしくは有効機嫌が切れている
     * ・EmailRestモデルのレコードを削除
     *
     * @param string $token
     * @return array
     */
    public function handle(string $token): array
    {
        $email_resets = EmailReset::where('token', $token)->first();

        if ($email_resets && !$this->tokenExpired($email_resets->created_at)) {

            // ユーザーのメールアドレスを更新
            $user = User::find($email_resets->user_id);
            $user->email = $email_resets->new_email;
            $user->save();

            EmailReset::where('token', $token)->delete();

            $message_type = 'flash_message';
            $message_content = 'メールアドレスを変更しました。';

        } else {

            EmailReset::where('token', $token)->delete();

            $message_type = 'error_message';
            $message_content = 'メールアドレスの変更に失敗しました。';
        }

        return [
            'type' => $message_type,
            'content' =>  $message_content,
        ];
    }

    /**
     * トークンが有効期限切れかどうかチェック
     *
     * @param string $createdAt
     * @return bool
     */
    private function tokenExpired(string $createdAt): bool
    {
        // トークンの有効期限は60分に設定
        $expires = 60 * 60;
        return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
    }
}
