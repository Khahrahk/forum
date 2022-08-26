<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Это пространство имен применяется к маршрутам контроллера.
     *
     * Он устанавливается как корневое пространство имен генератора URL.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Определяем привязки модели, маршрута, фильтров, шаблонов и т.д.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('channel', function ($slug) {
            return \App\Channel::withArchived()->where('slug', $slug)->firstOrFail();
        });
    }

    /**
     * Определяем маршруты.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Определяем веб-маршруты.
     *
     * Маршруты получают состояние сеанса, защиту CSRF и т.д.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Определяем маршруты "api".
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
