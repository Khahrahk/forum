@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->usernname }} ответил
        <a href="{{ $activity->subject->thread->path() }}">"{{ $activity->subject->thread->title }}"</a>
    @endslot

    @slot('body')
        {!! $activity->subject->body !!}
    @endslot
@endcomponent
