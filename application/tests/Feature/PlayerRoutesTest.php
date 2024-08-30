<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Player;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class PlayerRoutesTest extends TestCase
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

    public function test_should_access_player_routes(): void
    {
        $response = $this->get(route('player.index'));
        $response->assertStatus(200);

        $dashboardResponse = $this->get(route('dashboard'));
        $dashboardResponse->assertStatus(302);
        $dashboardResponse->assertRedirect(route('player.index'));

        $createResponse = $this->get(route('player.create'));
        $createResponse->assertStatus(200);

        $validPlayer = Player::all()[0];

        $editResponse = $this->get(route('player.edit', ['player' => $validPlayer->id]));
        $editResponse->assertStatus(200);
    }

    public function test_should_store_player(): void
    {
        $storeResponse = $this->post(route('player.store'), [
            'name' => 'Diego Lima', 
            'level' => 4,
            'is_goalkeeper' => false
        ]);
        $storeResponse->assertStatus(302);
        $storeResponse->assertRedirect(route('player.index'));
    }

    public function test_should_update_player(): void
    {
        $updateResponse = $this->put(route('player.update', ['player' => 1]), [
            'name' => 'Diego Lima', 
            'level' => 4,
            'is_goalkeeper' => false
        ]);
        $updateResponse->assertStatus(302);
        $updateResponse->assertRedirect(route('player.index'));
    }

    public function test_should_delete_player(): void
    {
        $deleteResponse = $this->delete(route('player.delete', ['id' => 1]));
        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJson([
            'result' => true,
            'messages' => 'Excluido com sucesso!'
        ]);
    }
}
