<?php

namespace App\Http\Controllers;

use App\Reply;

class BestRepliesController extends Controller
{
    /**
     * Отметить лучший ответ для обсуждения.
     *
     * @param  Reply $reply
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
    }
}
