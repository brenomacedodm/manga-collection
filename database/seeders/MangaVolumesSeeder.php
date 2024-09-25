<?php

namespace Database\Seeders;

use App\Models\MangaVolume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MangaVolumesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MangaVolume::create([
            "number" => 1,
            "manga_id" => 1
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 2,
            "manga_id" => 1
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 2,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 3,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 4,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 5,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 6,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 7,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 8,
            "manga_id" => 2
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 3
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 2,
            "manga_id" => 3
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 3,
            "manga_id" => 3
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 4
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 2,
            "manga_id" => 4
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 5
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 6
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 2,
            "manga_id" => 6
        ,"user_id" => 1]); 

        MangaVolume::create([
            "number" => 1,
            "manga_id" => 7
        ,"user_id" => 1]); 

        for ($i = 1; $i <= 42; $i++ ){
            MangaVolume::create([
                "number" => $i,
                "manga_id" => 8
            ,"user_id" => 1]); 
        }

        for ($i = 1; $i <= 7; $i++ ){
            MangaVolume::create([
                "number" => $i,
                "manga_id" => 9
            ,"user_id" => 1]); 
        }

        for ($i = 1; $i <= 1; $i++ ){
            MangaVolume::create([
                "number" => $i,
                "manga_id" => 10
            ,"user_id" => 1]); 
        }
    }
}
