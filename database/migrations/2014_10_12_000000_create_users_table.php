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
            $table->string('nombre')->required();
            $table->string('apellido1')->required();
            $table->string('apellido2')->nullable();
            $table->string('foto_perfil')->nullable();
            $table->string('email')->unique()->required();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->required();
            $table->string('confirmar_contraseña')->nullable(); // Agregado para confirmar contraseña
            $table->string('nacionalidad')->required();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('localidad')->required();
            $table->string('CP')->nullable();
            $table->integer('puntos')->default(0); // Agregado el campo de puntos
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
