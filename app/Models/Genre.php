<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        'pivot', 
        'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function mangas(){
        return $this->belongsToMany(Manga::class, 'manga_genre');
    }
}
