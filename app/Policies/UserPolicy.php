<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Определяем, может ли пользователь обновлять данный профиль.
     *
     * @param  \App\User $signedInUser
     * @param  \App\User $user
     * @return bool
     */
    public function update(User $signedInUser, User $user)
    {
        return $signedInUser->id === $user->id;
    }
}
