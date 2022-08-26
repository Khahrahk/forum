<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfilesController extends Controller
{
    /**
     * Получить обратную связь активности пользователя.
     *
     * @#param User $user
     */
    public function index(User $user)
    {
        return [
            'activities' => Activity::feed($user)
        ];
    }

    /**
     * Показать профиль пользователя.
     *
     * @param  User $user
     * @return \Response
     */
    public function show(User $user)
    {
        $data = ['profileUser' => $user];

        if (request()->expectsJson()) {
            return $data;
        }

        return view('profiles.show', $data);
    }
}
