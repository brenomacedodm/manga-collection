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
            $table->binary('picture')->nullable()->change();
        });

        Schema::table('mangas', function (Blueprint $table) {
            $table->binary('cover')->nullable()->change();
        });

        Schema::table('manga_volumes', function (Blueprint $table) {
            $table->binary('cover')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->binary('profile_pic')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blob', function (Blueprint $table) {
            //
        });
    }
};
