<?php

// This migration creates the 'fare_estimates' table with fields for associating fare estimates with rides, including provider information, estimated fare, estimated ETA, and an optional deep link URL. The 'ride_id' field is a foreign key that references the 'rides' table and will cascade on delete.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates the 'fare_estimates' table with fields for associating fare estimates with rides, including provider information, estimated fare, estimated ETA, and an optional deep link URL. The 'ride_id' field is a foreign key that references the 'rides' table and will cascade on delete.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method creates the 'fare_estimates' table with the specified schema, including a foreign key relationship to the 'rides' table and fields for provider, estimated fare, estimated ETA, deep link URL, and timestamps.
    public function up(): void
{
    // The 'fare_estimates' table is created with an auto-incrementing 'id', a foreign key 'ride_id' that references the 'rides' table and cascades on delete, a string field for 'provider', a decimal field for 'estimated_fare', an integer field for 'estimated_eta', an optional text field for 'deep_link_url', and standard timestamp fields for creation and updates.
  Schema::create('fare_estimates', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ride_id')
          ->constrained()
          ->onDelete('cascade');

    $table->string('provider');

    $table->decimal('estimated_fare', 10, 2);
    $table->integer('estimated_eta');

    $table->text('deep_link_url')->nullable();

    $table->timestamps();
});}

    /**
     * Reverse the migrations.
     */

    // The 'down' method drops the 'fare_estimates' table if it exists, effectively reversing the changes made by the 'up' method.
    public function down(): void
    {
        Schema::dropIfExists('fare_estimates');
    }
};
