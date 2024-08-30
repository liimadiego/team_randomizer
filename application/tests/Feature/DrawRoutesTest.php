<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DrawRoutesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--database' => 'mysql_testing']);

        $faker = Faker::create();
        $this->user = User::create([
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'name' => $faker->firstName(),
        ]);

        $this->actingAs($this->user);
    }

    public function test_should_access_draw_routes(): void
    {
        $response = $this->get(route('draw.index'));
        $response->assertStatus(200);

        $createResponse = $this->get(route('draw.create'));
        $createResponse->assertStatus(200);

        $editResponse = $this->get(route('draw.edit', ['draw' => 1]));
        $editResponse->assertStatus(200);
    }

    public function test_should_store_draw(): void
    {
        $players = Player::all();
        $everyEightPlayers = $players->chunk(8);

        $teams = [];
        $count = 0;
        foreach ($everyEightPlayers as $players) {
            $teams[$count]['players'] = $players->map(function ($player) {
                return [
                    "id" => $player->id,
                    "name" => $player->name,
                    "level" => $player->level,
                    "is_goalkeeper" => $player->is_goalkeeper
                ];
            });
            $count++;
        }

        $storeResponse = $this->post(route('draw.store'), [
            'players_per_team' => 8,
            'confirmed_players' => 25,
            'total_teams' => 4,
            'draw_date' => '2021-10-10 00:00:00',
            'teams' => $teams
        ]);
        $storeResponse->assertStatus(200);
        $storeResponse->assertJson([
            'result' => true,
            'messages' => 'Salvo com sucesso!',
            'id' => 1
        ]);
    }

    public function tear_down(): void
    {
    }
}
