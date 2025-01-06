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
        Schema::create('payments', function(Blueprint $table){

                $table->id();
                $table->date('date');
                $table->foreignId('bank_id')->constrained()->onDelete('cascade');
                $table->decimal('amount');
                $table->foreignId('receipt_payment_heading_id')->constrained()->onDelete('cascade');
                $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
