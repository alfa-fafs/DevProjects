<?php

// This migration adds 'phone', 'role', and 'preferences' columns to the 'users' table. The 'phone' column is a unique string that can be nullable, the 'role' column is an enum with values 'user' and 'admin' (defaulting to 'user'), and the 'preferences' column is a JSON field that can be nullable.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration adds 'phone', 'role', and 'preferences' columns to the 'users' table. The 'phone' column is a unique string that can be nullable, the 'role' column is an enum with values 'user' and 'admin' (defaulting to 'user'), and the 'preferences' column is a JSON field that can be nullable.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method adds the 'phone', 'role', and 'preferences' columns to the 'users' table with the specified attributes.
public function up(): void
{
    // The 'phone' column is added as a unique string that can be nullable, the 'role' column is added as an enum with values 'user' and 'admin' (defaulting to 'user'), and the 'preferences' column is added as a JSON field that can be nullable.
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->unique()->nullable()->after('id');
        $table->enum('role', ['user', 'admin'])->default('user')->after('phone');
        $table->json('preferences')->nullable()->after('role');
    });
}

    /**
     * Reverse the migrations.
     */
    // The 'down' method removes the 'phone', 'role', and 'preferences' columns from the 'users' table if they exist.
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'role', 'preferences']);
    });
}
};  
