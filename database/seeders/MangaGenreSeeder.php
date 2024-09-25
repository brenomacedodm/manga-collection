<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MangaGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //recado a adolf
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [1, 3]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [1, 5]);
        //buda
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [2, 5]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [2, 7]);
        //satsuma
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [3, 2]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [3, 3]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [3, 4]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [3, 5]);
        //tomie
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [4, 4]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [4, 1]);
        //cidade
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [5, 4]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [5, 1]);
        //cronicas
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [6, 3]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [6, 2]);
        //valise
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [7, 7]);
        //reborn
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [8, 2]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [8, 3]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [8, 6]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [8, 7]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [8, 8]);
        //punpun
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [9, 7]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [9, 4]);
        //fragmentos
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [10, 4]);
        DB::insert('insert into manga_genre (manga_id, genre_id) values (?, ?)', [10, 1]);
    }
}
