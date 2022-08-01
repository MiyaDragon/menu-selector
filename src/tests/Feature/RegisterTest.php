<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testRegisterFormAccess()
    {
        // ユーザー登録ページへアクセス
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function testUserRegister()
    {
        // ユーザー登録ページへアクセス
        $response = $this->get(route('register'));
        $response->assertStatus(200)->assertViewIs('auth.register');

        // ユーザー登録情報を定義
        $register_url = route('register');
        $register_data = [
            'name' => 'ユーザーテスト',
            'email' => 'test@test.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass',
        ];
        // ユーザー登録
        $response = $this->post($register_url, $register_data);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('/');

        // データの存在確認
        $this->assertDatabaseHas('users', ['name' => $register_data['name']]);
    }
}
