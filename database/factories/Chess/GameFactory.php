<?php

namespace Database\Factories\Chess;

use App\Models\Chess\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chess\Game>
 */
class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $whitePlayer = User::factory()->create();
        $blackPlayer = User::factory()->create();

        return [
            'white_player_id' => $whitePlayer->id,
            'black_player_id' => $blackPlayer->id,
            'fen' => 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
            'turn' => fake()->randomElement(['white', 'black']),
            'status' => fake()->randomElement(['pending', 'active', 'completed']),
            'result' => null,
            'start_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_at' => null,
        ];
    }

    /**
     * Indicate that the game is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_at' => now(),
            'end_at' => null,
        ]);
    }

    /**
     * Indicate that the game is completed.
     */
    public function completed(): static
    {
        $startAt = fake()->dateTimeBetween('-1 month', '-1 hour');
        $endAt = fake()->dateTimeBetween($startAt, 'now');
        
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'result' => fake()->randomElement(['white_win', 'black_win', 'draw']),
            'start_at' => $startAt,
            'end_at' => $endAt,
        ]);
    }

    /**
     * Indicate that the game is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'start_at' => null,
            'end_at' => null,
        ]);
    }
}
