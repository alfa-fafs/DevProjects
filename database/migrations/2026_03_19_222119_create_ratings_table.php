<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ride_id')->constrained('rides')->onDelete('cascade');
            $table->unsignedTinyInteger('stars'); // 1-5
            $table->text('comment')->nullable();
            $table->string('provider'); // Bolt, Uber etc
            $table->timestamps();

            $table->index('user_id');
            $table->index('ride_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};