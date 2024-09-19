<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class PublishersPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function defaultPolicy(User $user): Response
    {
        return $user->is_admin
            ? Response::allow()
            : Response::deny();
    }

}
