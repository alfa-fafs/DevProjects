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
//location details 
 $table->string('pickup_address');
 $table->decimal('pickup_lat', 10, 8);
 $table->decimal('pickup_lng', 11, 8);
 $table->string('dropoff_address');
 $table->decimal('dropoff_lat', 10, 8);
 $table->decimal('dropoff_lng', 11, 8);
 // Ride details
 $table->string('provider',['uber','bolt','indrive','taxi']); // Bolt, Uber, inDrive, Taxi
 $table->string('vehicle_type');
 $table->string('distance_km',8,2)->nullable();
 $table->string('duration_minutes')->nullable();
 $table->integer('eta')->nullable(); // Estimated time of arrival in minutes
 
// Booking details
 $table->string('booking_status',[
 'compared',
 'completed',
 'cancelled'
 ])->default('compared'); // compared, booked, completed, cancelled
$table->string('booking_reference')->nullable();
 $table->timestamp('booked_at')->nullable();
 $table->timestamp('completed_at')->nullable();
 
 $table->timestamps();
 
// Indexes for common queries
 $table->index('user_id');
 $table->index('provider');
 $table->index('booking_status');
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
