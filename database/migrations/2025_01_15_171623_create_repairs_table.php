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
        Schema::create('repair_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 8, 2);
            $table->integer('duration');
        
        });
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('users');
            $table->unsignedBigInteger('repair_type');
            $table->foreign('repair_type')->references('id')->on('repair_types');
            $table->integer('status');
            $table->text('description');
            $table->time('scheduled_time')->default(DB::raw('CURRENT_TIMESTAMP'));
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
        Schema::dropIfExists('repair_types');
    }
};
