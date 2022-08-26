<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * URI, которые следует исключить из проверки CSRF.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
