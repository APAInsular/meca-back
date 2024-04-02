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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ["Escultura","Mural","Pintura"]);
            $table->date('fecha_creacion');
            $table->string('imagen_principal');
            $table->decimal('latitud');
            $table->decimal('longitud');
            $table->text('significado');
            $table->foreignId('estilo_id');
            $table->foreignId('q_r_id');
            $table->foreignId('direccion_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
