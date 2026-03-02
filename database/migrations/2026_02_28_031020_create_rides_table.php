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
        Schema::create('rides', function (Blueprint $table) {
           $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('pickup_address');
    $table->decimal('pickup_lat', 10, 8);
    $table->decimal('pickup_lng', 11, 8);
    $table->string('dropoff_address');
    $table->decimal('dropoff_lat', 10, 8);
    $table->decimal('dropoff_lng', 11, 8);
    $table->enum('provider', ['uber','bolt','indrive','taxi']);
    $table->string('vehicle_type');
    $table->decimal('price', 8, 2);
    $table->enum('booking_status', ['compared','booked','completed','cancelled'])->default('compared');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
