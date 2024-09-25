<?php

namespace App\Observers;

use DB;
use Illuminate\Database\Eloquent\Model;

class MangaObserver extends EntityObserver
{
    public function creating(Model $model): void
    {
        Parent::creating($model);
    }

    public function created(Model $manga){
        $new = $manga->find($manga->id);

        $volumes = [];
        for ($i = 1; $i <= (int)$new->volumes; $i++){
            DB::insert("insert into manga_volumes (number, manga_id, user_id) values (?, ?, ?)", [$i, $new->id, $new->user_id]);
        }

        throw new \Exception(json_encode($volumes), 401);

    }

    public function updating(Model $manga): void{
        Parent::updating($manga);

        $updating = $manga->find($manga->id);

        if($manga->volumes != $manga->getOriginal('volumes')){
            DB::delete("delete from manga_volumes where manga_id = $updating->id");
            for ($i = 1; $i <= (int)$manga->volumes; $i++){
                DB::insert("insert into manga_volumes (number, manga_id, user_id) values (?, ?, ?)", [$i, $updating->id, $updating->user_id]);
            }
        }

    }

    public function deleting(Model $model): void{
        Parent::deleting($model);
    }
}
