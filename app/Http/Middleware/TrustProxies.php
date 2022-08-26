<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Надежные прокси для этого приложения.
     *
     * @var array
     */
    protected $proxies;

    /**
     * Заголовки, которые следует использовать для обнаружения прокси.
     *
     * @var string
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
