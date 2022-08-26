<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    /**
     * Создает новый экземпляр контроллера.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Сохраняет новое избранное в базе данных.
     *
     * @param  Reply $reply
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        $reply->owner->gainReputation('reply_favorited');
    }

    /**
     * Удаляет избранное.
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();

        $reply->owner->loseReputation('reply_favorited');
    }
}
