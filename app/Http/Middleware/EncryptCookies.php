<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * Имена файлов cookie, которые не следует шифровать.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
