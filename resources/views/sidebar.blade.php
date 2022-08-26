<aside class="bg-grey-lightest p-6 pr-10 border-l border-r w-64">
    @yield('sidebar-top')

    <div class="widget border-b-0">
        @if (auth()->check())
            @if(auth()->user()->confirmed)
                <button class="btn bg-black hover:bg-grey-darkest w-full" @click="$modal.show('new-thread')">Добавить новый тред</button>
            @else
                <p class="text-xs text-grey-dark font-bold border border-dashed border-grey-dark p-3">Пожалуйста, подтвердите ваш Email для общения.</p>
            @endif
        @else
            <button class="btn bg-black w-full tracking-wide hover:bg-grey-darkest" @click="$modal.show('login')">Войдите чтобы постить</button>
        @endif
    </div>

    <div class="widget">
        <h4 class="widget-heading">Смотреть</h4>

        <ul class="mb-2 list-reset text-sm">
            <li class="pb-3">
                <a href="/threads" class="flex items-center text-black hover:text-grey-darkest hover:font-bold {{ Request::is('threads') && ! Request::query() ? 'text-grey-darkest font-bold' : '' }}">
                    @include ('svgs.icons.all-threads', ['class' => 'mr-2 text-grey'])
                    Все треды
                </a>
            </li>

            @if (auth()->check())
                <li class="pb-3">
                    <a href="/threads?by={{ auth()->user()->username }}"
                       class="flex items-center text-black hover:text-grey-darkest hover:font-bold  {{ Request::query('by') ? 'text-grey-darkest font-bold' : '' }}"
                    >
                        <img src="{{ auth()->user()->avatar_path }}"
                             alt="{{ auth()->user()->username }}"
                             class="w-4 h-4 mr-3 bg-grey text-grey-darkest rounded-full p-1">

                        Мои треды
                    </a>
                </li>
            @endif

            <li class="pb-3">
                <a href="/threads?popular=1" class="flex items-center text-black hover:text-grey-darkest hover:font-bold {{ Request::query('popular') ? 'text-black font-bold' : '' }}">
                    @include ('svgs.icons.star', ['class' => 'mr-2 text-grey'])
                    Популярные треды
                </a>
            </li>

            <li class="pb-3">
                <a href="/threads?unanswered=1" class="flex items-center text-black hover:text-grey-darkest hover:font-bold {{ Request::query('unanswered') ? 'text-black font-bold' : '' }}">
                    @include ('svgs.icons.question', ['class' => 'mr-2 text-grey'])
                    Неотвеченные треды
                </a>
            </li>

            <li>
                <a href="/leaderboard" class="flex items-center text-black hover:text-grey-darkest hover:font-bold {{ request()->getPathInfo() === '/leaderboard' ? 'text-black font-bold' : '' }}">
                    @include ('svgs.icons.leaderboard', ['class' => 'mr-2 text-grey'])
                    Таблица лидеров
                </a>
            </li>

        </ul>

    </div>

    @if (count($trending))
        <div class="widget">
            <h4 class="widget-heading">Популярное</h4>

            <ul class="list-reset">
                @foreach ($trending as $thread)
                    <li class="pb-3 text-sm">
                        <a href="{{ url($thread->path) }}" class="link text-black">
                            {{ $thread->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</aside>
