@extends('admin.layout.app')

@section('administration-content')
    <p class="mb-8">
        <a class="btn bg-blue" href="{{ route('admin.channels.create') }}">
            Новый канал <span class="glyphicon glyphicon-plus"></span>
        </a>
    </p>

    <table style="border-collapse: collapse">
        <thead class="bg-grey-lightest text-grey-darkest uppercase tracking-wide text-xs">
            <tr>
                <th class="p-4 border-b" colspan="2">Имя</th>
                <th class="p-4 border-b">Заголовок</th>
                <th class="p-4 border-b">Описание</th>
                <th class="p-4 border-b">Треды</th>
                <th class="p-4 border-b">Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($channels as $channel)
                <tr class="border-b {{ $channel->archived ? 'bg-red-lighter' : '' }}">
                    <td class="pl-4 pt-4 pb-4 border-b">
                        <span class="rounded-full inline-block h-3 w-3 mr-2" style="background: {{ $channel->color }}"></span>
                    </td>
                    <td class="text-sm pt-4 pb-4 pr-4 border-b">{{ $channel->name }}</td>
                    <td class="text-sm p-4 border-b">{{ $channel->slug }}</td>
                    <td class="text-sm p-4 border-b">{{ $channel->description }}</td>
                    <td class="text-sm p-4 border-b">{{ $channel->threads_count }}</td>
                    <td class="text-sm p-4 border-b">
                        <a href="{{ route('admin.channels.edit', $channel) }}" class="text-blue link text-sm">Редактировать</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>Здесь пусто.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
