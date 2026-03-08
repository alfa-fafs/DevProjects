<?php

// This migration creates the 'jobs', 'job_batches', and 'failed_jobs' tables for managing background jobs in the application.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration creates the 'jobs', 'job_batches', and 'failed_jobs' tables for managing background jobs in the application.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method defines the schema for the 'jobs', 'job_batches', and 'failed_jobs' tables.
    public function up(): void
    {
        // The 'jobs' table stores information about background jobs, including the queue, payload, attempts, and timestamps.
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        // The 'job_batches' table stores information about batches of jobs, including the batch name, total jobs, pending jobs, failed jobs, and timestamps.
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        // The 'failed_jobs' table stores information about failed background jobs, including the connection, queue, payload, exception, and timestamps.
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    //  The 'down' method drops the 'jobs', 'job_batches', and 'failed_jobs' tables if they exist.
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
