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
        Schema::create('collection_manga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained();
            $table->foreignId('manga_id')->constrained();
            $table->unique(['collection_id', 'manga_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_collection_manga');
    }
};
