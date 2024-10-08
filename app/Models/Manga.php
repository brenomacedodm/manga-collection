<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\MangaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([MangaObserver::class])]
class Manga extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "genre_id",
        "author_id",
        "volumes",
        "on_going",
        "cover",
        "about",
        "publisher_id"
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

    public function volumes(){
        return $this->hasMany(MangaVolume::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }
    public function genres(){
        return $this->belongsToMany(Genre::class, 'manga_genre');
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }

    public function collections(){
        return $this->belongsToMany(Collection::class,'collection_manga');
    }

    public function scopeWhereName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }
    
}
