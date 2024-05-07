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
            $table->string('name')->required();
            $table->string('first_surname')->required();
            $table->string('second_surname')->required();
            $table->string('profile_picture')->nullable();
            $table->string('nickname')->unique()->required();
            $table->string('email')->unique()->required();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->required();
            $table->string('confirm_password')->required(); // Added for password confirmation
            $table->string('nationality')->required();
            $table->date('date_of_birth')->nullable();
            $table->string('location')->required();
            $table->string('postal_code')->nullable();
            $table->integer('points')->default(0); // Added the points field
            $table->rememberToken();
            $table->timestamps();
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
