<?php

namespace App\Listeners;

use App\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Обрабатывает событие.
     *
     * @param  mixed $event
     * @return void
     */
    public function handle($event)
    {
        tap($event->subject(), function ($subject) {
            User::whereIn('username', $this->mentionedUsers($subject))
                ->get()->each->notify(new YouWereMentioned($subject));
        });
    }

    /**
     * Получить всех упомянутых пользователей в основной части ответа.
     *
     * @return array
     */
    public function mentionedUsers($body)
    {
        preg_match_all('/@([\w\-]+)/', $body, $matches);

        return $matches[1];
    }
}
