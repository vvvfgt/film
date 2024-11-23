<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('film_genre', function (Blueprint $table) {
           $table->foreignId('film_id')
               ->constrained()
               ->cascadeOnDelete();
           $table->foreignId('genre_id')
               ->constrained()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('film_genre');
    }
};
