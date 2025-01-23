<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leaderboard;
use App\Models\User;

class LeaderboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Pretpostavlja se da već ima korisnika u bazi
         Leaderboard::create([
            'user_id' => 1, // ID korisnika
            'points' => 1500, // Broj poena
        ]);

        Leaderboard::create([
            'user_id' => 2, // ID korisnika
            'points' => 1200, // Broj poena
        ]);

        Leaderboard::create([
            'user_id' => 3, // ID korisnika
            'points' => 1800, // Broj poena
        ]);

        Leaderboard::create([
            'user_id' => 4, // ID korisnika
            'points' => 2000, // Broj poena
        ]);
    }
}
