<?php

// This migration creates the 'rides' table with fields for user association, pickup and dropoff locations (both as strings and as latitude/longitude), ride status, and timestamps. The 'user_id' field is a foreign key that references the 'users' table and will cascade on delete.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates the 'rides' table with fields for user association, pickup and dropoff locations (both as strings and as latitude/longitude), ride status, and timestamps. The 'user_id' field is a foreign key that references the 'users' table and will cascade on delete.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method creates the 'rides' table with the specified schema, including a foreign key relationship to the 'users' table and fields for pickup/dropoff locations, coordinates, status, and timestamps.
   public function up(): void
{
    // The 'rides' table is created with an auto-incrementing 'id', a foreign key 'user_id' that references the 'users' table and cascades on delete, string fields for 'pickup_location' and 'dropoff_location', decimal fields for latitude and longitude of both pickup and dropoff locations, a 'status' field that defaults to 'pending', and standard timestamp fields for creation and updates.
    Schema::create('rides', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('pickup_location');
        $table->string('dropoff_location');

        $table->decimal('pickup_lat', 10, 7);
        $table->decimal('pickup_lng', 10, 7);
        $table->decimal('dropoff_lat', 10, 7);
        $table->decimal('dropoff_lng', 10, 7);
        $table->string('status')->default('pending');

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    // The 'down' method drops the 'rides' table if it exists, effectively reversing the changes made by the 'up' method.
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
