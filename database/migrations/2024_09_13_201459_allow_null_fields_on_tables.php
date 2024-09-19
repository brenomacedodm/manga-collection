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
        Schema::table("publishers", function (Blueprint $table) {
            $table->string("publisher_link")->nullable()->change();
        });

        Schema::table("authors", function (Blueprint $table) {
            $table->string("picture")->nullable()->change();
        });

        Schema::table("manga_volumes", function (Blueprint $table) {
            $table->string("amazon_link")->nullable()->change();
            $table->string("cover")->nullable()->change();
        });

        Schema::table("mangas", function (Blueprint $table) {
            $table->string("about")->nullable()->change();
            $table->boolean("on_going")->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
