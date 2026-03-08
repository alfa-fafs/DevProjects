<?php

// This migration creates the 'cache' and 'cache_locks' tables for caching functionality in the application.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates the 'cache' and 'cache_locks' tables for caching functionality in the application.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method defines the schema for the 'cache' and 'cache_locks' tables.
    public function up(): void
    {
        // The 'cache' table stores cached data with a key, value, and expiration time.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        // The 'cache_locks' table is used for managing locks on cache keys to prevent
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    // The 'down' method drops the 'cache' and 'cache_locks' tables if they exist.
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
