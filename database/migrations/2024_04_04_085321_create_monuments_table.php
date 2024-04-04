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
        Schema::create('monuments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ["Sculpture","Mural","Painting"]);
            $table->date('creation_date');
            $table->string('main_image');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->text('meaning');
            $table->foreignId('style_id');
            $table->foreignId('q_r_id');
            $table->foreignId('address_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monuments');
    }
};
