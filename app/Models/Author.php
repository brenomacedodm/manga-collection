<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "picture"
    ];

    protected $hidden = [
        'pivot', 
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
    
    public function mangas(){
        return $this->belongsToMany(Manga::class);
    }

}
  