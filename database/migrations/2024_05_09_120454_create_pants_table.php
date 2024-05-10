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
        Schema::create('pants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sex_id');
            $table->string('category');
            $table->string('subcategory');
            $table->string('url');
            $table->string('url_selection');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pants');
    }
};
