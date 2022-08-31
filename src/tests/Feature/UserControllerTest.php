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

    /**
     * ユーザー名変更（成功）
     */
    public function testNameUpdate()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // ユーザー情報編集画面へアクセス
        $response = $this->get(route('users.editName'));
        $response->assertStatus(200)->assertViewIs('users.edit_name');

        // 献立更新情報を定義
        $update_url = route('users.updateName');
        $update_data = [
            'name' => 'アップデート',
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('users/edit');

        // データの存在確認
        $this->assertDatabaseHas('users', ['name' => $update_data['name']]);
    }

    /**
     * ユーザー名変更（失敗）
     */
    public function testNameUpdateFailed()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // ユーザー情報編集画面へアクセス
        $response = $this->get(route('users.editName'));
        $response->assertStatus(200)->assertViewIs('users.edit_name');

        // ユーザー更新情報を定義
        $update_url = route('users.updateName');
        $update_data = [
            'name' => '',
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        // 求めるエラーメッセージ
        $response->assertSessionHasErrors(['name' => 'ユーザー名は必ず指定してください。']);
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('users/edit/name');
    }

    // /**
    //  * メールアドレス変更（成功）
    //  */
    // public function testEmailUpdate()
    // {
    //     // ログイン状態
    //     $response = $this->actingAs($this->user);
    //     // ユーザー情報編集画面へアクセス
    //     $response = $this->get(route('users.editEmail'));
    //     $response->assertStatus(200)->assertViewIs('users.edit_email');

    //     // 献立更新情報を定義
    //     $update_url = route('users.updateEmail');
    //     $update_data = [
    //         'email' => 'update@update.com',
    //     ];
    //     // 更新
    //     $response = $this->put($update_url, $update_data);
    //     $response->assertSessionHasNoErrors();
    //     // リダイレクト
    //     $response->assertStatus(302)->assertRedirect('users/edit');

    //     // データの存在確認
    //     $this->assertDatabaseHas('users', ['email' => $update_data['email']]);
    // }

    // /**
    //  * メールアドレス変更（失敗）
    //  */
    // public function testEmailUpdateFailed()
    // {
    //     // ログイン状態
    //     $response = $this->actingAs($this->user);
    //     // ユーザー情報編集画面へアクセス
    //     $response = $this->get(route('users.editEmail'));
    //     $response->assertStatus(200)->assertViewIs('users.edit_email');

    //     // ユーザー更新情報を定義
    //     $update_url = route('users.updateEmail');
    //     $update_data = [
    //         'email' => 'update',
    //     ];
    //     // 更新
    //     $response = $this->put($update_url, $update_data);
    //     // 求めるエラーメッセージ
    //     $response->assertSessionHasErrors(['email' => '有効なメールアドレスを指定してください。']);
    //     // リダイレクト
    //     $response->assertStatus(302)->assertRedirect('users/edit/email');
    // }

    // /**
    //  * パスワード変更（成功）
    //  */
    // public function testPasswordUpdate()
    // {
    //     // ログイン状態
    //     $response = $this->actingAs($this->user);
    //     // ユーザー情報編集画面へアクセス
    //     $response = $this->get(route('users.editPassword'));
    //     $response->assertStatus(200)->assertViewIs('users.edit_password');

    //     // 献立更新情報を定義
    //     $update_url = route('users.updatePassword');
    //     $old_password = 'password';
    //     $new_password = 'new_password';
    //     $update_data = [
    //         'password' => $old_password,
    //         'new_password' => $new_password,
    //         'new_password_confirmation' => $new_password,
    //     ];
    //     // 更新
    //     $response = $this->put($update_url, $update_data);
    //     $response->assertSessionHasNoErrors();
    //     // リダイレクト
    //     $response->assertStatus(302)->assertRedirect('users/edit');
    // }

    // /**
    //  * パスワード変更（失敗）
    //  */
    // public function testPasswordUpdateFailed()
    // {
    //     // ログイン状態
    //     $response = $this->actingAs($this->user);
    //     // ユーザー情報編集画面へアクセス
    //     $response = $this->get(route('users.editPassword'));
    //     $response->assertStatus(200)->assertViewIs('users.edit_password');

    //     // ユーザー更新情報を定義
    //     $update_url = route('users.updatePassword');
    //     $old_password = 'password';
    //     $new_password = 'new_password';
    //     $update_data = [
    //         'password' => $old_password,
    //         'new_password' => $new_password,
    //         'new_password_confirmation' => 'passwordFailed',
    //     ];
    //     // 更新
    //     $response = $this->put($update_url, $update_data);
    //     // 求めるエラーメッセージ
    //     $response->assertSessionHasErrors(['new_password' => 'パスワードが一致していません。']);
    //     // リダイレクト
    //     $response->assertStatus(302)->assertRedirect('users/edit/password');
    // }
}
