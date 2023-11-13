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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('role_id')->default(1);
            $table->unsignedTinyInteger('rank_id')->default(1);
            $table->unsignedBigInteger('points')->default(0);
            $table->string('login', 32)->unique();
            $table->string('email', 256)->nullable()->unique();
            $table->string('password', 256);

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('rank_id')->references('id')->on('ranks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
