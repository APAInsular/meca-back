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
            $table->string('name')->required();
            $table->string('first_surname')->required();
            $table->string('second_surname')->required();
            $table->date('date_of_birth')->required();
            $table->date('date_of_death')->nullable();
            $table->string('location')->required();
            $table->string('country')->required();
            $table->text('description')->required();
            $table->string('image')->required();
            $table->string('video')->nullable();
            $table->timestamps();
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
