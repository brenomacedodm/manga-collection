<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class AuthorMangaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [1, 1]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [2, 1]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [3, 9]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [4, 8]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [5, 8]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [6, 2]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [7, 2]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [8, 3]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [9, 5]);
        DB::insert('insert into author_manga (manga_id, author_id) values (?, ?)', [10, 8]);
    }
}
