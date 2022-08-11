<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testLogin()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200)->assertViewIs('auth.login');

        // ログインする
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('/');
        // ユーザーがログイン認証されているか
        $this->assertAuthenticatedAs($this->user);
    }

    public function testLoginFailed()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200)->assertViewIs('auth.login');
        // パスワードを間違いログインする
        $response = $this->post(route('login'), [
            'email' => $this->user->email,
            'password' => 'pass'
        ]);
        // 求めるエラーメッセージ
        $response->assertSessionHasErrorsIn("ログイン情報が登録されていません。");
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('/login');
        // ユーザーが認証されていないか
        $this->assertGuest();
    }

    // public function testLogout()
    // {
    //     // ログイン状態
    //     $response = $this->actingAs($this->user);
    //     // トップページへアクセス
    //     $response = $this->get('/');
    //     $response->assertStatus(200)->assertViewIs('home');

    //     // ログアウト処理
    //     $this->post('logout');
    //     $response->assertStatus(200);

    //     // ログアウト後、トップページにいること
    //     $response = $this->get('/')->assertStatus(200);
    //     // ユーザーが認証されていないこと
    //     $this->assertGuest();
    // }
}
