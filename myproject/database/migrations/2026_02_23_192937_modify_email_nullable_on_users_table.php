<?php

// This migration modifies the 'email' column in the 'users' table to allow null values, making it nullable. The 'up' method applies this change, while the 'down' method reverts it back to non-nullable if needed.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration modifies the 'email' column in the 'users' table to allow null values, making it nullable. The 'up' method applies this change, while the 'down' method reverts it back to non-nullable if needed.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method modifies the 'email' column in the 'users' table to be nullable, allowing it to store null values if no email is provided for a user.
    public function up(): void
{
    // The 'email' column in the 'users' table is modified to allow null values, making it nullable. This change allows for users to be created without an email address if necessary.
    Schema::table('users', function (Blueprint $table) {
        $table->string('email')->nullable()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    // The 'down' method reverts the 'email' column in the 'users' table back to non-nullable, meaning it will not allow null values and will require an email address for each user.
    public function down(): void
{
    // The 'email' column in the 'users' table is modified to be non-nullable again, meaning it will not allow null values and will require an email address for each user. This effectively reverses the change made in the 'up' method.
    Schema::table('users', function (Blueprint $table) {
        $table->string('email')->nullable(false)->change();
    });
}
};
