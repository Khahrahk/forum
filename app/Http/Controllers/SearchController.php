<?php

namespace App\Http\Controllers;

use App\Thread;

class SearchController extends Controller
{
    /**
     * Показать результаты поиска.
     *
     * @return mixed
     */
    public function show()
    {
        if (request()->expectsJson()) {
            return Thread::search(request('q'))->paginate(25);
        }

        return view('threads.search');
    }
}
