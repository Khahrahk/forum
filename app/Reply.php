<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    /**
     * Не добавляем автоматическую защиту.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Определяем зависимости нагрузи от каждого запроса.
     *
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * Аксессоры для добавления к форме массива модели.
     *
     * @var array
     */
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest', 'xp', 'path'];

    /**
     * Загружаем экземпляр ответа.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');

            $reply->owner->gainReputation('reply_posted');
        });

        static::deleting(function ($reply) {
            $reply->thread->decrement('replies_count');

            $reply->owner->loseReputation('reply_posted');

            if ($reply->isBest()) {
                $reply->thread->removeBestReply();
            }
        });
    }

    /**
     * Ответ принадлежит пользователю.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Ответ принадлежит треду.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Получаем соответствующий заголовок для ответа.
     */
    public function title()
    {
        return $this->thread->title;
    }

    /**
     * Определяем, был ли ответ опубликован только что.
     *
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Определяем путь к ответу.
     *
     * @return string
     */
    public function path()
    {
        $perPage = config('council.pagination.perPage');

        $replyPosition = $this->thread->replies()->pluck('id')->search($this->id) + 1;

        $page = ceil($replyPosition / $perPage);

        return $this->thread->path()."?page={$page}#reply-{$this->id}";
    }

    /**
     * Получаем путь к потоку в виде свойства.
     */
    public function getPathAttribute()
    {
        return $this->path();
    }

    /**
     * Доступ к атрибуту основного текста.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    /**
     * Устанавливаем атррибуты для основого текста.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }

    /**
     * Определяем, отмечен ли текущий ответ как лучший.
     *
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * Определяем, отмечен ли текущий ответ как лучший.
     *
     * @return bool
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    /**
     * Подсчитываем правильную сумму XP, заработанную за текущий ответ.
     */
    public function getXpAttribute()
    {
        $xp = config('council.reputation.reply_posted');

        if ($this->isBest()) {
            $xp += config('council.reputation.best_reply_awarded');
        }

        return $xp += $this->favorites()->count() * config('council.reputation.reply_favorited');
    }
}
