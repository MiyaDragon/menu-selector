<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Genre;

use function Symfony\Component\String\s;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();

        $response = $this->get(route('home'));

        $response->assertStatus(200)->assertViewIs('home');
    }
}
