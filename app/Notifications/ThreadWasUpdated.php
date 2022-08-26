<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{
    /**
     * Тред, которая была обновлена.
     *
     * @var \App\Thread
     */
    protected $thread;

    /**
     * Новый ответ.
     *
     * @var \App\Reply
     */
    protected $reply;

    /**
     * Создает новый экземпляр уведомления.
     *
     * @param \App\Thread $thread
     * @param \App\Reply  $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Получаем уведомления о каналах.
     *
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Получаем представленные уведомления в виде массива.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->owner->name.' ответил '.$this->thread->title,
            'notifier' => $this->reply->owner,
            'link' => $this->reply->path()
        ];
    }
}
