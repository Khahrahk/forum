<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Прослушиваем события.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ThreadReceivedNewReply::class => [
            \App\Listeners\NotifyMentionedUsers::class,
            \App\Listeners\NotifySubscribers::class
        ],

        \App\Events\ThreadWasPublished::class => [
            \App\Listeners\NotifyMentionedUsers::class
        ],
    ];

    /**
     * Регистрируем события.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
