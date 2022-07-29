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

    public function testCreate()
    {
        $user = User::factory()->create();

        // ログインする
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);

        $response = $this->get(route('menus.create'));
        $response->assertStatus(200)->assertViewIs('menus.create');

        $response = $this->post(route('menus.store'), ['name' => 'カレーライス', 'genre' => '洋食', 'user_id' => $user->id]);
        $response->assertStatus(302)->assertRedirect('/');
    }

    // public function testDelete()
    // {
    //     $user = User::factory()->create();

    //     // ログインする
    //     $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);

    //     $response = $this->get(route('menus.delete'));
    //     $response->assertStatus(200)->assertViewIs('menus.delete');

    //     $genre = Genre::factory()->create();
    //     $menu = Menu::factory()->create();

    //     $response = $this->post(route('menus.destroy'), ['menu_id' => $menu->id, 'genre_id' => $menu->genre_id]);
    //     $response->assertStatus(302)->assertRedirect('menus/delete');
    // }
}
