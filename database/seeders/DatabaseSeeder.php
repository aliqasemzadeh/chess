<?php

namespace Database\Seeders;

use App\Models\Chess\Game;
use App\Models\Chess\Move;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@chess.com',
            'password' => bcrypt('password'),
        ]);

        // Create 10 chess players with chess.com emails
        $users = User::factory()->count(10)->chessPlayer()->create();

        // Create 5 games with moves
        for ($i = 0; $i < 5; $i++) {
            $whitePlayer = $users->random();
            $blackPlayer = $users->where('id', '!=', $whitePlayer->id)->random();
            
            $game = Game::factory()->create([
                'white_player_id' => $whitePlayer->id,
                'black_player_id' => $blackPlayer->id,
                'status' => fake()->randomElement(['active', 'completed']),
            ]);

            // Add some moves to each game
            $moveCount = fake()->numberBetween(5, 15);
            for ($j = 1; $j <= $moveCount; $j++) {
                Move::factory()->create([
                    'game_id' => $game->id,
                    'move_number' => $j,
                ]);
            }
        }
    }
}
