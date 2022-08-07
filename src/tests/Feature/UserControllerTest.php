<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Genre;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->genre = Genre::factory()->create(['user_id' => $this->user->id]);
        $this->menu = Menu::factory()->create(['user_id' => $this->user->id, 'genre_id' => $this->genre->id]);
    }

    public function testUserUpdate()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // ユーザー情報編集画面へアクセス
        $response = $this->get(route('users.edit'));
        $response->assertStatus(200)->assertViewIs('users.edit');

        // 献立更新情報を定義
        $update_url = route('users.update');
        $update_data = [
            'name' => 'アップデート',
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => $this->user->password,
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('users/edit');

        // データの存在確認
        $this->assertDatabaseHas('users', ['name' => $update_data['name']]);
    }

    public function testNameUpdateFailed()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // ユーザー情報編集画面へアクセス
        $response = $this->get(route('users.edit'));
        $response->assertStatus(200)->assertViewIs('users.edit');

        // ユーザー更新情報を定義
        $update_url = route('users.update');
        $update_data = [
            'name' => '',
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => $this->user->password,
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        // 求めるエラーメッセージ
        $response->assertSessionHasErrorsIn("ユーザー名は必ず指定してください。");
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('users/edit');
    }

    public function testPasswordUpdateFailed()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // ユーザー情報編集画面へアクセス
        $response = $this->get(route('users.edit'));
        $response->assertStatus(200)->assertViewIs('users.edit');

        // ユーザー更新情報を定義
        $update_url = route('users.update');
        $update_data = [
            'name' => 'アップデート',
            'email' => $this->user->email,
            'password' => $this->user->password,
            'password_confirmation' => 'pass',
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        // 求めるエラーメッセージ
        $response->assertSessionHasErrorsIn("パスワードが一致していません。");
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('users/edit');
    }
}
