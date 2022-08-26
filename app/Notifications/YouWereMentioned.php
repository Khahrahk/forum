<?php

namespace App\Notifications;

use App\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class YouWereMentioned extends Notification
{
    use Queueable;

    /**
     * @var \App\Reply or \App\Thread
     */
    protected $subject;

    /**
     * Создать новый экземпляр уведомления.
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Получаем уведомления о каналах.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Получаем представленные уведомления в виде массива.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message(),
            'notifier' => $this->user(),
            'link' => $this->subject->path()
        ];
    }

    /**
     * Получаем тему сообщения для уведомления.
     */
    public function message()
    {
        return sprintf('%s упомянул вас в "%s"', $this->user()->username, $this->subject->title());
    }

    /**
     * Получаем связанного пользователя для темы.
     */
    public function user()
    {
        return $this->subject instanceof Reply ? $this->subject->owner : $this->subject->creator;
    }
}
