<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Mail\BareMail;
use App\Notifications\UpdateEmailNotification;

class EmailReset extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'new_email',
        'token',
    ];

    /**
     * メールアドレス変更メールを送信
     * @param string $token
     */
    public function sendEmailResetNotification($token)
    {
        $this->notify(new UpdateEmailNotification($token, new BareMail()));
    }
}
