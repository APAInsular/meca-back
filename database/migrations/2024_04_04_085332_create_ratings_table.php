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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->enum('rating', ["1", "2", "3", "4", "5"]);  
            $table->morphs('rateable');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Agregar restricción única en las columnas user_id, likable_type, y likable_id
            $table->unique(['rating', 'rateable_type', 'rateable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
