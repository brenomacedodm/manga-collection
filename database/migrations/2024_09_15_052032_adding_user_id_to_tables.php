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
        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        Schema::table('publishers', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        Schema::table('genres', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        Schema::table('mangas', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
        Schema::table('manga_volumes', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
