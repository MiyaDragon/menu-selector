<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Genre;
use App\Models\Menu;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        // トップページへアクセス
        $response = $this->get(route('home'));
        $response->assertStatus(200)->assertViewIs('home');
    }

    public function testShowMenu()
    {
        // ログイン状態
        $response = $this->actingAs($this->user);
        // トップページへアクセス
        $response = $this->get(route('home'));
        $response->assertStatus(200)->assertViewIs('home');

        $genre = Genre::factory()->create([
            'name' => 'ジャンルテスト',
            'user_id' => $this->user->id,
        ]);

        $menu = Menu::factory()->create([
            'name' => 'メニューテスト',
            'user_id' => $this->user->id,
            'genre_id' => $genre->id,
        ]);

        $show_url = route('show');
        $show_data = [
            'genre_id' => $genre->id,
        ];
        // メニュー表示処理
        $response = $this->post($show_url, $show_data);
        $response->assertSessionHasNoErrors();

        // トップページを表示
        $response->assertStatus(200)->assertViewIs('home');

        // 先ほど作成したmenuのnameと一致するものが表示されているか
        $response->assertSeeText($menu['name']);
    }
}
