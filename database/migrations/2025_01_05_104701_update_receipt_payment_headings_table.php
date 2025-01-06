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
        Schema::table('receipt_payment_headings', function (Blueprint $table) {
            // Modify 'uuid' to make it unique
            $table->string('uuid')->unique()->change();

            // Modify 'type' column to be an enum
            $table->enum('type', ['receipt', 'payment'])->change();

            // Add 'description' column
            $table->string('description')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipt_payment_headings', function (Blueprint $table) {
            // Rollback changes made in the 'up' method
            $table->dropColumn('description');
            $table->dropUnique(['uuid']); // Drop unique constraint
            $table->string('type')->change(); // Revert to the original type column type
        });
    }
};
