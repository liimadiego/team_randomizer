<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DrawRoutesTest extends TestCase
{
    private User $admin;

    public function test_should_access_draw_routes(): void
    {
        $faker = Faker::create();
        $this->user = User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'name' => $faker->firstName(),
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('draw.index'));
        $response->assertStatus(200);

        $dashboardResponse = $this->get(route('dashboard'));
        $dashboardResponse->assertStatus(302);
        $dashboardResponse->assertRedirect(route('player.index'));

        $createResponse = $this->get(route('draw.create'));
        $createResponse->assertStatus(200);

        $storeResponse = $this->post(route('draw.store'), [
            'players_per_team' => 5,
            'confirmed_players' => 10,
            'total_teams' => 2,
            'draw_date' => '2021-10-10 00:00:00',
        ]);
        $storeResponse->assertStatus(302);
        $storeResponse->assertRedirect(route('draw.index'));

    }
}
