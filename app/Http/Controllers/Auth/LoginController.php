<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер входа
    |--------------------------------------------------------------------------
    |
    | Этот контроллер обрабатывает аутентификацию пользователей для сайта и
    | перенаправляя их на домашний экран.
    |
    */

    use AuthenticatesUsers;

    /**
     * Куда перенаправлять пользователей после входа.
     *
     * @var string
     */
    protected $redirectTo = '/threads';

    /**
     * Создает новый экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Пользователь прошел аутентификацию.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->wantsJson()) {
            return response()->json(['redirect' => $this->redirectTo], 200);
        }

        redirect()->intended($this->redirectPath());
    }
}
