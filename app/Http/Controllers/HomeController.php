<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Создает новый экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Показывает панель сайта.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
