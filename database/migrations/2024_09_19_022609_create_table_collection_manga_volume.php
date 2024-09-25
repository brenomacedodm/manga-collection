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
        Schema::create('collection_volume', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_manga_id');
            $table->foreign('collection_manga_id')->references('id')->on('collection_manga')->onDelete('cascade');
            $table->foreignId('manga_volume_id')->constrained();
            $table->unique(['collection_manga_id','manga_volume_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_collection_manga_volume');
    }
};
