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
        Schema::table('mangas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('genre_id');
            $table->dropConstrainedForeignId('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->foreignId('manga_id')->constrained();
            $table->foreignId('genre_id')->constrained();
        });
    }
};
