<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     *  表示文字数制限をしたジャンル名を取得
     *
     * @param int $limit
     * @return string
     */
    public function getLimitName(int $limit = 20): string
    {
        $name = $this->name;

        if (mb_strlen($name) > $limit) {
            $name = mb_substr($name, 0, $limit);
            return $name . "...";
        } else {
            return $name;
        }
    }
}
