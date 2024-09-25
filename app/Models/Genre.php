<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\EntityObserver;

#[ObservedBy([EntityObserver::class])]

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function mangas(){
        return $this->belongsToMany(Manga::class, 'manga_genre');
    }
}
