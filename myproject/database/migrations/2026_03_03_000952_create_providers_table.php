<?php

// This migration creates a new table called 'providers' with various columns to store information about ride providers such as their name, slug, deep link URL, API availability, active status, and fallback estimation system details. The 'up' method defines the structure of the table, while the 'down' method drops the table if the migration is rolled back.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates a new table called 'providers' with various columns to store information about ride providers such as their name, slug, deep link URL, API availability, active status, and fallback estimation system details. The 'up' method defines the structure of the table, while the 'down' method drops the table if the migration is rolled back.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method creates the 'providers' table with the specified columns and their attributes. This includes an auto-incrementing 'id', 'name', 'slug', 'deep_link_url', 'api_available', 'is_active', and fallback estimation system details such as 'base_fare', 'per_km_rate', and 'per_minute_rate'. Timestamps for created_at and updated_at are also included.
    public function up(): void
{
    // The 'providers' table is created with an auto-incrementing 'id', a string 'name' for the provider's name, a unique string 'slug' for URL-friendly identifiers, an optional string 'deep_link_url' for redirecting to the provider's app or website, boolean fields 'api_available' and 'is_active' to indicate API availability and active status, and decimal fields for fallback estimation system details including 'base_fare', 'per_km_rate', and 'per_minute_rate'. Standard timestamp fields are also included for tracking creation and updates.
    Schema::create('providers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Bolt, Uber, inDrive, Taxi
        $table->string('slug')->unique(); // bolt, uber, indrive
        $table->string('deep_link_url')->nullable(); // for redirect
        $table->boolean('api_available')->default(false);
        $table->boolean('is_active')->default(true);

        // Fallback estimation system
        $table->decimal('base_fare', 8, 2)->default(0);
        $table->decimal('per_km_rate', 8, 2)->default(0);
        $table->decimal('per_minute_rate', 8, 2)->default(0);

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    // The 'down' method drops the 'providers' table if it exists, effectively reversing the changes made by the 'up' method.
    public function down(): void
{
    Schema::dropIfExists('providers');
}
};
