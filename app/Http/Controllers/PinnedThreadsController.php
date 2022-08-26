<?php

namespace App\Http\Controllers;

use App\Thread;

class PinnedThreadsController extends Controller
{
    /**
     * Отметить данную тему.
     *
     * @param \App\Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->update(['pinned' => true]);
    }

    /**
     * Отменить закрепление данной темы.
     *
     * @param \App\Thread $thread
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['pinned' => false]);
    }
}
