<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            "name"=> "Terror",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Ação",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Aventura",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Adulto",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Histórico",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Romance",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Drama",
            "user_id" => 1
        ]);
        Genre::create([
            "name"=> "Comédia",
            "user_id" => 1
        ]);
    }
}
