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
        Schema::create('manga_volumes', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->unsignedBigInteger('manga_id');
            $table->foreign('manga_id')->references('id')->on('mangas');
            $table->string('cover');
            $table->string('amazon_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manga_volumes');
    }
};
