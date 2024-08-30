<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;
use Faker\Factory as Faker;

class PlayerFactory extends Factory
{
    /**
     * O nome do modelo que esta fábrica está configurada para gerar.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Defina o estado padrão do modelo.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        Player::create([
            'name' => $faker->firstName,
            'level' => $faker->numberBetween(1, 5),
            'is_goalkeeper' => $faker->boolean(15),
        ]);
    }
}
