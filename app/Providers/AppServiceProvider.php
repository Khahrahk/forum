<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Загружаем некоторые сервисы.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Регистрируем некоторые сервисы.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
