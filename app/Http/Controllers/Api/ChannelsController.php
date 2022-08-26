<?php

namespace App\Http\Controllers\Api;

use App\Channel;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    /**
     * Получить все каналы.
     */
    public function index()
    {
        return cache()->rememberForever('channels', function () {
            return Channel::all();
        });
    }
}
