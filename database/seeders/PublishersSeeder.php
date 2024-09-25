<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublishersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::create([
            "name"=> "Panini Mangas",
            "publisher_link" => "https://panini.com.br/",
            "user_id" => 1
        ]);
        Publisher::create([
            "name"=> "Pipoca & Nanquim",
            "publisher_link" => "https://pipocaenanquim.com.br",
            "user_id" => 1
        ]);
        Publisher::create([
            "name"=> "JBC Mangas",
            "publisher_link" => "https://editorajbc.com.br",
            "user_id" => 1
        ]);
        Publisher::create([
            "name"=> "Darkside",
            "publisher_link" => "https://www.darksidebooks.com.br",
            "user_id" => 1
        ]);
    }
}
