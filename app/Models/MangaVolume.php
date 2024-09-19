<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaVolume extends Model
{
    use HasFactory;

    protected $fillable = [
        "number",
        "manga_id",
        "cover",
        "amazon_link"
    ];

    protected $hidden = [
        'user_id'  
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function mangas(){
        return $this->belongsTo(Manga::class);
    }
}
