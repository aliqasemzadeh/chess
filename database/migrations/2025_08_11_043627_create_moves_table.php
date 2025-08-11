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
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('move_number');
            $table->string('from', 2); // e.g. e2
            $table->string('to', 2);   // e.g. e4
            $table->string('san');     // Standard Algebraic Notation
            $table->text('fen_before');
            $table->text('fen_after');
            $table->json('meta')->nullable(); // promotion, capture, check, etc.
            $table->timestamps();

            $table->index(['game_id', 'move_number']);
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
