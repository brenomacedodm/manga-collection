<?php

namespace Database\Seeders;

use App\Models\CollectionManga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionMangaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CollectionManga::create([
            "manga_id" => 8,
            "collection_id" => 1
        ]);
        CollectionManga::create([
            "manga_id" => 9,
            "collection_id" => 1
        ]);
    }
}
