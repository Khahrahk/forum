<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class Trending
{
    /**
     * Получаем все популярные треды.
     *
     * @return array
     */
    public function get()
    {
        return Cache::get($this->cacheKey(), collect())
                    ->sortByDesc('score')
                    ->slice(0, 5)
                    ->values();
    }

    /**
     * Поместите новый тред в список популярных.
     *
     * @param Thread $thread
     */
    public function push($thread, $increment = 1)
    {
        $trending = Cache::get($this->cacheKey(), collect());

        $trending[$thread->id] = (object) [
            'score' => $this->score($thread) + $increment,
            'title' => $thread->title,
            'path' => $thread->path(),
        ];

        Cache::forever($this->cacheKey(), $trending);
    }

    /**
     * Получаем очки популярности для данного треда.
     *
     * @param int
     */
    public function score($thread)
    {
        $trending = Cache::get($this->cacheKey(), collect());

        if (! isset($trending[$thread->id])) {
            return 0;
        }

        return $trending[$thread->id]->score;
    }

    /**
     * Сбрасываем все популярные треды.
     */
    public function reset()
    {
        return Cache::forget($this->cacheKey());
    }

    /**
     * Получаем ключи имени кэша.
     *
     * @return string
     */
    private function cacheKey()
    {
        return 'trending_threads';
    }
}
