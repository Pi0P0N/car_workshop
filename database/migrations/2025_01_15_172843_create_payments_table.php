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
        
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // repair_id
            $table->unsignedBigInteger('repair_id');
            $table->foreign('repair_id')->references('id')->on('repairs');
            // payment status from PaymentStatusEnum
            $table->integer('status');
            // payment amount
            $table->decimal('amount', 8, 2);
            // payment client
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users');
            // payment employee
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('payments');
    }
};
