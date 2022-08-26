<?php

namespace App\Http\Controllers\Admin;

use App\Channel;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ChannelsController extends Controller
{
    /**
     * Показать все каналы.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channel::withArchived()->with('threads')->get();

        return view('admin.channels.index', compact('channels'));
    }


    /**
     * Показать форму для создания канала.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.channels.create', ['channel' => new Channel]);
    }

    /**
     * Показать форму для редактирования существующего канала.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    /**
     * Обновить существующий канал.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Channel $channel)
    {
        $channel->update(
            request()->validate([
                'name' => ['required', Rule::unique('channels')->ignore($channel->id)],
                'description' => 'required',
                'color' => 'required',
                'archived' => 'required|boolean'
            ])
        );

        cache()->forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 200);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Ваш канал был обновлен!');
    }

    /**
     * Сохранить новый канал.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $channel = Channel::create(
            request()->validate([
                'name' => 'required|unique:channels',
                'color' => 'required',
                'description' => 'required',
            ])
        );

        cache()->forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 201);
        }

        return redirect(route('admin.channels.index'))
            ->with('flash', 'Ваш канал был создан!');
    }
}
