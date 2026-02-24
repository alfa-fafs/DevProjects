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
    Schema::create('fare_estimates', function (Blueprint $table) {
        $table->id();

        $table->string('provider'); // bolt, uber, indrive, taxi

        $table->decimal('base_fare', 10, 2);
        $table->decimal('per_km_rate', 10, 2);
        $table->decimal('per_min_rate', 10, 2);

        $table->foreignId('updated_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fare_estimates');
    }
};
