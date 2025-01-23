<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leaderboard;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin', // Eksplicitno postavljen kao ADMIN
        ]);

        User::create([
            'username' => 'Bora Drljaca',
            'email' => 'moderator@example.com',
            'password' => Hash::make('mod123'),
            'role' => 'player', // Eksplicitno postavljen kao player
        ]);

        User::create([
            'username' => 'Rai Wulf',
            'email' => 'player1@example.com',
            'password' => Hash::make('player123'),
            // 'role' nije prosleđen, koristi podrazumevanu vrednost (IGRAC)
        ]);

        User::create([
            'username' => 'Aco Pejovic',
            'email' => 'player2@example.com',
            'password' => Hash::make('player456'),
            // 'role' nije prosleđen, koristi podrazumevanu vrednost (IGRAC)
        ]);
    }
}
