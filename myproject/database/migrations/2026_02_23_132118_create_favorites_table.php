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
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('nickname'); // e.g. "Home", "Work"

        $table->string('pickup_location');
        $table->string('dropoff_location');

        $table->decimal('pickup_lat', 10, 7);
        $table->decimal('pickup_lng', 10, 7);

        $table->decimal('dropoff_lat', 10, 7);
        $table->decimal('dropoff_lng', 10, 7);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
