<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mangas(){
        return $this->belongsToMany(Manga::class, 'collection_manga');
    }
    public function mangaVolumes(){
        return $this->belongsToMany(MangaVolume::class, 'collection_volume');
    }
    
}
