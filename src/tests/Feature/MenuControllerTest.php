<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Genre;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->genre = Genre::factory()->create(['user_id' => $this->user->id]);
        $this->menu = Menu::factory()->create(['user_id' => $this->user->id, 'genre_id' => $this->genre->id]);
    }

    public function testMenuCreate()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // 献立作成画面へアクセス
        $response = $this->get(route('menus.create'));
        $response->assertStatus(200)->assertViewIs('menus.create');

        // 献立作成情報を定義
        $create_url = route('menus.store');
        $create_data = [
            'menu_name' => '寿司',
            'genre_name' => '和食',
            'user_id' => $this->user->id,
        ];
        // 作成
        $response = $this->post($create_url, $create_data);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('/menus/create');

        // データの存在確認(menus)
        $this->assertDatabaseHas('menus', ['name' => $create_data['menu_name']]);
        // データの存在確認(genres)
        $this->assertDatabaseHas('genres', ['name' => $create_data['genre_name']]);
    }

    public function testMenuUpdate()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // 献立編集画面へアクセス
        $response = $this->get(route('menus.edit', ['menu' => $this->menu->id]));
        $response->assertStatus(200);

        // 献立更新情報を定義
        $update_url = route('menus.update', ['menu' => $this->menu->id]);
        $update_data = [
            'menu_name' => 'アップデート',
            'genre_name' => $this->genre->name,
        ];
        // 更新
        $response = $this->put($update_url, $update_data);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('menus');

        // データの存在確認
        $this->assertDatabaseHas('menus', ['name' => $update_data['menu_name']]);
    }

    public function testMenuDelete()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // 献立一覧画面（削除ボタンあり）へアクセス
        $response = $this->get(route('menus.index'));
        $response->assertStatus(200)->assertViewIs('menus.index');

        // データの存在確認
        $this->assertDatabaseHas('menus', ['id' => $this->menu->id]);

        // 献立削除情報を定義
        $delete_url = route('menus.destroy', ['menu' => $this->menu->id]);
        // 削除
        $response = $this->delete($delete_url);
        $response->assertSessionHasNoErrors();
        // リダイレクト
        $response->assertStatus(302)->assertRedirect('menus');

        // データが消された事
        $this->assertDeleted($this->menu);
        // データが存在しない事
        $this->assertDatabaseMissing('menus', ['id' => $this->menu->id]);
    }
}
