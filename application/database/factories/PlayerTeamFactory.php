<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
use App\Models\Player;

class PlayerTeamFactory extends Factory
{
    protected $model = \App\Models\PlayerTeam::class;

    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'player_id' => Player::factory(),
        ];
    }
}
