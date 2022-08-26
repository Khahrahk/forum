<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер сброса пароля
    |--------------------------------------------------------------------------
    |
    | Этот контроллер отвечает за обработку запросов на сброс пароля.
    |
    */

    use ResetsPasswords;

    /**
     * Куда перенаправлять пользователей после сброса пароля.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Создает новый экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
