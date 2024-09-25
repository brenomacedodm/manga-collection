<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
            
    ];

    public function collectionMangas(){
        return $this->hasMany(CollectionManga::class, 'collection_id');
    }

    public function mangas(){
            return $this->belongsToMany(Manga::class, 'collection_manga', 'collection_id', 'manga_id'); 
    }

    public function volumes(){
        return $this->hasManyThrough(CollectionVolume::class, CollectionManga::class, 'collection_id', 'collection_manga_id');
    }

    
}
