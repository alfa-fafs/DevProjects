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

        $table->string('pickup_location');
        $table->string('dropoff_location');

        $table->decimal('pickup_lat', 10, 7);
        $table->decimal('pickup_lng', 10, 7);
        $table->decimal('dropoff_lat', 10, 7);
        $table->decimal('dropoff_lng', 10, 7);

        $table->string('provider'); // bolt, uber, indrive, taxi

        $table->decimal('estimated_fare', 10, 2);
        $table->integer('estimated_eta'); // in minutes

        $table->enum('booking_status', [
            'pending',
            'redirected',
            'completed',
            'cancelled'
        ])->default('pending');

        $table->text('deep_link_url')->nullable();

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
