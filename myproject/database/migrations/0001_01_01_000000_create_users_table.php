<?php

// This migration creates the 'users' table along with tables for password reset tokens and sessions.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates the 'users' table along with tables for password reset tokens and sessions.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method defines the schema for the 'users', 'password_reset_tokens', and 'sessions' tables.
    public function up(): void
    {
        // The 'users' table stores user information such as name, email, password, and timestamps.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // The 'password_reset_tokens' table stores tokens for password reset functionality.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // The 'sessions' table stores session information for user authentication and tracking.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    // The 'down' method drops the 'users', 'password_reset_tokens', and 'sessions' tables if they exist.
    public function down(): void
    {
        // Drop the 'users' table along with the 'password_reset_tokens' and 'sessions' tables.
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
