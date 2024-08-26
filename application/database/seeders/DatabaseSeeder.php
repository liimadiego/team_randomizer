<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Player;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $goalkeeperCount = 0;
        $maxGoalkeepers = 3;

        for ($i = 0; $i < 25; $i++) {
            $isGoalkeeper = $goalkeeperCount < $maxGoalkeepers && $faker->boolean(15);

            if ($isGoalkeeper) {
                $goalkeeperCount++;
            }

            Player::create([
                'name' => $faker->firstName,
                'level' => $faker->numberBetween(1, 5),
                'is_goalkeeper' => $isGoalkeeper,
            ]);
        }
    }
}
