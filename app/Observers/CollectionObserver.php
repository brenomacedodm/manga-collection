<?php

namespace App\Observers;

use App\Exceptions\UnauthorizedAccessException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CollectionObserver extends EntityObserver
{
    public function creating(Model $model): void
    {
        $user = User::find($model->user_id);

        if (!$user || $user->email_verified_at == null ) {
            throw new UnauthorizedAccessException("You're not allowed to create a collection without verifying your email", 401);
        }
    }
}
