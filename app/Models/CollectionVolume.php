<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionVolume extends Model
{
    use HasFactory;

    protected $table = "collection_volume";
    public $timestamps = false;

    protected $fillable = [
        "collection_manga_id",
        "manga_volume_id"
    ];

    protected $hidden = [
    ];

    public function collections(){
        return $this->belongsTo(CollectionManga::class,'collection_manga_id');
    }

    public function volumes(){
        return $this->belongsTo(MangaVolume::class,'manga_volume_id');
    }
}
