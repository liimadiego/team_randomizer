<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Draw;

class TeamFactory extends Factory
{
    protected $model = \App\Models\Team::class;

    public function definition()
    {
        return [
            'draw_id' => Draw::factory(),
            'name' => $this->faker->company
        ];
    }
}
