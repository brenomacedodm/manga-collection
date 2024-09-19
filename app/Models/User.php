<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_pic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function authors(){
        return $this->hasMany(Author::class);
    }
    public function collections(){
        return $this->hasMany(Collection::class);
    }
    public function genres(){
        return $this->hasMany(Genre::class);
    }
    public function mangas(){
        return $this->hasMany(Manga::class);
    }
    public function mangaVolumes(){
        return $this->hasMany(MangaVolume::class);
    }
    public function publishers(){
        return $this->hasMany(Publisher::class);
    }
    
}
