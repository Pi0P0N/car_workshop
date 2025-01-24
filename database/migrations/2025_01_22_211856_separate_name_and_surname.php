<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
        });

        User::all()->each(function ($user) {
            $nameParts = explode(' ', $user->name, 2);
            $user->first_name = $nameParts[0];
            $user->last_name = $nameParts[1] ?? '';
            $user->save();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });

        User::all()->each(function ($user) {
            $user->name = $user->first_name . ' ' . $user->last_name;
            $user->save();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
        });
    }
};