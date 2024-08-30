<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class DrawFactory extends Factory
{
    protected $model = \App\Models\Draw::class;

    public function definition()
    {
        return [
            'draw_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'players_per_team' => $this->faker->numberBetween(5, 6),
            'total_teams' => $this->faker->numberBetween(2, 5),
            'confirmed_players' => $this->faker->numberBetween(14, 25),
        ];
    }
}
