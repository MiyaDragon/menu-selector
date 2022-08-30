<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * ゲストユーザーの作成
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'ゲストユーザー',
            'email' => 'guest@guest.com',
        ]);
    }
}
