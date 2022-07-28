<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

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
}
