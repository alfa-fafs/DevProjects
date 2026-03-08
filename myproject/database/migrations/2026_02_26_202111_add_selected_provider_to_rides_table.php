<?php

// This migration adds a new column 'selected_provider' to the 'rides' table, which is a string that can be nullable. The 'up' method adds this column after the 'status' column, while the 'down' method removes it if the migration is rolled back.
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This migration adds a new column 'selected_provider' to the 'rides' table, which is a string that can be nullable. The 'up' method adds this column after the 'status' column, while the 'down' method removes it if the migration is rolled back.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // The 'up' method adds a new column 'selected_provider' to the 'rides' table. This column is of type string, can be nullable, and is added after the 'status' column in the table. This allows for storing the selected provider for a ride if applicable.
    public function up(): void
{
    // The 'selected_provider' column is added to the 'rides' table as a nullable string, allowing it to store the name of the selected provider for a ride if applicable. This column is added after the 'status' column in the table.
    Schema::table('rides', function (Blueprint $table) {
        $table->string('selected_provider')->nullable()->after('status');
    });
}

    /**
     * Reverse the migrations.
     */
    // The 'down' method removes the 'selected_provider' column from the 'rides' table if it exists, effectively reversing the changes made by the 'up' method.
    public function down(): void
{
    Schema::table('rides', function (Blueprint $table) {
        $table->dropColumn('selected_provider');
    });
}
};
