<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\UnauthorizedAccessException;

class EntityObserver
{
    public function creating(Model $model): void
    {
        $user = User::find($model->user_id);

        if (!$user || !$user->is_admin ) {
            throw new UnauthorizedAccessException("You're not allowed to create entities", 401);
        }
    }

    public function updating(Model $model): void{
        $user = User::find($model->user_id);

        if (!$user || !$user->is_admin ) {
            throw new UnauthorizedAccessException("You're not allowed to update entities",401);
        }
    }

    public function deleting(Model $model): void{
        $user = User::find($model->user_id);

        if (!$user || !$user->is_admin ) {
            throw new UnauthorizedAccessException("You're not allowed to delete entities", 401);
        }
    }
}
