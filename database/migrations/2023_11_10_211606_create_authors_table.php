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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->nullable();
            $table->string('surname', 64)->nullable();
            $table->string('patronymic', 64)->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->dateTime('date_of_death')->nullable();
            $table->string('origin', 64)->nullable();
            $table->string('desc', 1024)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
