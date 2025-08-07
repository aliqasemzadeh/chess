<?php

namespace Database\Factories\Chess;

use App\Models\Chess\Game;
use App\Models\Chess\Move;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chess\Move>
 */
class MoveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Move::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commonMoves = [
            ['from' => 'e2', 'to' => 'e4', 'piece' => 'P', 'san' => 'e4'],
            ['from' => 'e7', 'to' => 'e5', 'piece' => 'p', 'san' => 'e5'],
            ['from' => 'g1', 'to' => 'f3', 'piece' => 'N', 'san' => 'Nf3'],
            ['from' => 'b8', 'to' => 'c6', 'piece' => 'n', 'san' => 'Nc6'],
            ['from' => 'f1', 'to' => 'c4', 'piece' => 'B', 'san' => 'Bc4'],
            ['from' => 'f8', 'to' => 'c5', 'piece' => 'b', 'san' => 'Bc5'],
            ['from' => 'e1', 'to' => 'g1', 'piece' => 'K', 'san' => 'O-O'],
            ['from' => 'd7', 'to' => 'd6', 'piece' => 'p', 'san' => 'd6'],
        ];

        $move = fake()->randomElement($commonMoves);

        return [
            'game_id' => Game::factory(),
            'from_square' => $move['from'],
            'to_square' => $move['to'],
            'piece' => $move['piece'],
            'san' => $move['san'],
            'move_number' => fake()->numberBetween(1, 50),
            'fen_after_move' => 'rnbqkbnr/pppppppp/8/8/4P3/8/PPPP1PPP/RNBQKBNR b KQkq e3 0 1',
        ];
    }
}
