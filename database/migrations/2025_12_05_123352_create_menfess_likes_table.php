<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menfess_likes', function (Blueprint $table) {
            $table->id();
            // Mencatat siapa yang like postingan mana
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('menfess_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menfess_likes');
    }
};