<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserAvatarController extends Controller
{
    /**
     * Сохранить новый аватар пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'avatar' => ['required', 'image']
        ]);

        Storage::disk('public')->delete(auth()->user()->getOriginal('avatar_path'));

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }
}
