<?php

namespace App\User\UseCase;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\EmailReset;

final class UpdateEmailLinkUseCase
{
    /**
     * 新しいメールアドレスに、認証メールを送信する
     *
     * @param string $new_email
     */
    public function send(string $new_email)
    {
        $new_email = $new_email;

        // トークン生成
        $token = hash_hmac(
            'sha256',
            Str::random(40) . $new_email,
            config('app.key')
        );

        $email_reset = EmailReset::create([
            'user_id' => Auth::id(),
            'new_email' => $new_email,
            'token' => $token,
        ]);

        $email_reset->sendEmailResetNotification($token);
    }
}
