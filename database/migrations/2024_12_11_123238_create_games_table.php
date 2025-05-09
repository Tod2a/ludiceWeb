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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('description');
            $table->date('published_at');
            $table->string('name');
            $table->string('img_path');
            $table->integer('min_players');
            $table->integer('max_players');
            $table->integer('average_duration');
            $table->bigInteger('EAN')->nullable();
            $table->integer('suggestedage');
            $table->boolean('is_expansion')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
