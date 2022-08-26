<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Сопоставления политик для приложения.
     *
     * @var array
     */
    protected $policies = [
        \App\Thread::class => \App\Policies\ThreadPolicy::class,
        \App\Reply::class => \App\Policies\ReplyPolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Зарегистрируйте любые службы аутентификации / авторизации.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::before(function ($user) {
//            if ($user->name === 'John Doe') return true;
//        });
    }
}
