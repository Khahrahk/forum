@extends('layouts.app')

@section('sidebar')
    <aside class="bg-grey-lightest p-6 pr-10 border-l border-r w-64">
        <div class="widget">
            <h4 class="widget-heading">Управление</h4>

            <ul class="list-reset text-sm">
                <li class="pb-3">
                    <a href="{{ route('admin.dashboard.index') }}" class="{{ Route::is('admin.dashboard.index') ? 'text-blue font-bold' : '' }}">Панель</a>
                </li>

                <li class="pb-3">
                    <a href="{{ route('admin.channels.index') }}" class="{{ Route::is('admin.channels.index') ? 'text-blue font-bold' : '' }}">Каналы</a>
                </li>

                <li class="pb-3">
                    <a href="{{ route('admin.slider.slider') }}" class="{{ Route::is('admin.slider.slider') ? 'text-blue font-bold' : '' }}">Слайдер</a>
                </li>
            </ul>
        </div>
    </aside>
@endsection

@section('content')
    <div class="py-6">
        @yield('administration-content')
    </div>
@endsection
