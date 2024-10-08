<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\EntityObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([EntityObserver::class])]
class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "publisher_link"
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'

    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

}
