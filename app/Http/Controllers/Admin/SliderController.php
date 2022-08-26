<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    /**
     * Показать все каналы.
     *
     * @return \Illuminate\Http\Response
     */
    public function slider()
    {
        $channels = Channel::withArchived()->with('threads')->get();

        return view('admin.slider.slider', compact('channels'));
    }

}