<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(UsersSeeder::class);
        $this->call(AuthorsSeeder::class);
        $this->call(GenresSeeder::class);
        $this->call(PublishersSeeder::class);
        $this->call(MangasSeeder::class);
        $this->call(AuthorMangaSeeder::class);
        $this->call(MangaGenreSeeder::class);
        $this->call(MangaVolumesSeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(CollectionMangaSeeder::class);
    }
}
