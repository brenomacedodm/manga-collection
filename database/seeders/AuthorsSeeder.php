<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            "name"=> "Osamu Tezuka",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Jiro Taniguchi",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Akira Amano",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Yoshiro Togashi",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Inio Asano",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Masashi Kishimoto",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Go Nagai",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Junji Ito",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Hiroshi Hirata",
            "user_id" => 1
        ]);
        Author::create([
            "name"=> "Kan Takahama",
            "user_id" => 1
        ]);
    }
}
