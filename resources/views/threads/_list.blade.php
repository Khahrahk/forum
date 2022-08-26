@forelse ($threads as $thread)
    <div class="flex {{ $loop->last ? '' : 'mb-6 pb-4' }}">
        <div class="mr-4">
            <img src="{{ $thread->creator->avatar_path }}"
                     alt="{{ $thread->creator->username }}"
                     class="w-8 h-8 bg-black rounded-full p-2">
        </div>

        <div class="flex-1 {{ $loop->last ? '' : 'border-b border-blue-lightest' }}">
            <h3 class="text-xl font-normal mb-2 tracking-tight">
                <a href="{{ $thread->path() }}" class="text-black">
                    @if ($thread->pinned)
                        Закреплено:
                    @endif

                    @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                        <strong>
                            {{ $thread->title }}
                        </strong>
                    @else
                        {{ $thread->title }}
                    @endif
                </a>
            </h3>

            <p class="text-2xs text-grey-darkest mb-4">
                Запостил: <a href="{{ route('profile', $thread->creator) }}" class="text-grey-dark">{{ $thread->creator->username }}</a>
            </p>

            <thread-view :thread="{{ $thread }}" inline-template class="mb-6 text-grey-darkest leading-loose pr-8">
                <highlight :content="body"></highlight>
            </thread-view>

            <div class="flex items-center text-xs mb-6">
                <a class="btn bg-grey-light hover:bg-grey-darkest text-grey-darkest py-2 px-3 mr-4 text-2xs flex items-center" href="/threads/{{ $thread->channel->slug }}">
                    <span class="rounded-full h-2 w-2 mr-2" style="background: {{ $thread->channel->color }}"></span>

                    {{ ucwords($thread->channel->name) }}
                </a>

                <span class="mr-2 flex items-center text-grey-darker text-2xs font-semibold mr-4">
                    @include ('svgs.icons.eye', ['class' => 'mr-2'])
                    {{ $thread->visits }} визитов
                </span>

                <a href="{{ $thread->path() }}" class="mr-2 flex items-center text-grey-darker text-2xs font-semibold">
                    @include ('svgs.icons.book', ['class' => 'mr-2'])
                    {{ $thread->replies_count }} {{ 'ответов' }}
                </a>

                <a class="btn ml-auto hover:bg-grey-darkest is-outlined text-grey-darker py-2 text-xs" href="{{ $thread->path() }}">читать дальше</a>
            </div>
        </div>
    </div>
@empty
    <p>Нет результатов.</p>
@endforelse
