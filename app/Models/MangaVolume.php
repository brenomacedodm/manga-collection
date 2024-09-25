<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaVolume extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function mangas(){
        return $this->belongsTo(Manga::class);
    }

    public function collections(){
        return $this->belongsToMany(Collection::class,'collection_volume');
    }
}
