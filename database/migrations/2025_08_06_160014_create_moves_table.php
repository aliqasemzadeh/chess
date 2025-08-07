<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('moves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('from_square', 2); // e.g., 'e2'
            $table->string('to_square', 2); // e.g., 'e4'
            $table->string('piece'); // e.g., 'P' for pawn
            $table->string('san')->nullable(); // Standard Algebraic Notation
            $table->integer('move_number');
            $table->string('fen_after_move'); // FEN after this move
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moves');
    }
};
