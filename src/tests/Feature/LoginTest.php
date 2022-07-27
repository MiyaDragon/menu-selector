<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        $user = User::factory()->create();

        $response = $this->get(route('login'));
        $response->assertStatus(200)->assertViewIs('auth.login');

        // ログインする
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(302)->assertRedirect('/');
        // ユーザーがログイン認証されているか
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginNg()
    {
        $user = User::factory()->create();

        $response = $this->get(route('login'));
        $response->assertStatus(200)->assertViewIs('auth.login');

        // パスワードを間違いログインする
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'passwordng']);
        $response->assertStatus(302)->assertRedirect('/login');
        // ユーザーが認証されていないか
        $this->assertGuest();
    }

    public function testLogout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200)->assertViewIs('home');
        // ログアウトする
        $this->post('logout');
        $response->assertStatus(200);
        // ログアウト後、トップページにいること
        $response = $this->get('/')->assertStatus(200);
        // ユーザーが認証されていないこと
        $this->assertGuest();
    }
}
