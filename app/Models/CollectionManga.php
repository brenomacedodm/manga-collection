<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionManga extends Model
{
    use HasFactory;

    protected $table = "collection_manga";
    public $timestamps = false;
    protected $fillable = [
        "collection_id",
        "manga_id"
    ];

    protected $hidden = [
    ];

    public function collection(){
        return $this->belongsTo(Collection::class,'collection_manga');
    }

    public function mangas(){
        return $this->belongsTo(Manga::class,'manga_id');
    }

    public function volumes(){
        return $this->hasMany(CollectionVolume::class,'collection_manga_id');
    }
}
