<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Filters\ThreadFilters;
use App\Events\ThreadWasPublished;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Thread extends Model
{
    use RecordsActivity, Searchable;

    /**
     * Не применяем автоматическую защиту.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Связи к постоянной подгрузке.
     *
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * Аксессоры для добавления к форме массива модели.
     *
     * @var array
     */
    protected $appends = ['path'];

    /**
     * Атрибуты, которые следует приводить к собственным типам.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
        'pinned' => 'boolean'
    ];

    /**
     * Загружаем модель.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();

            $thread->creator->loseReputation('thread_published');
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);

            event(new ThreadWasPublished($thread));

            $thread->creator->gainReputation('thread_published');
        });
    }

    /**
     * Получаем строковый путь для треда.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * Получаем путь к треду как свойство.
     */
    public function getPathAttribute()
    {
        if (! $this->channel) {
            return '';
        }

        return $this->path();
    }

    /**
     * Тред принадлежит пользователю.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Получаем заголовок треда.
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Тред принадлежит к какому-то каналу.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class)->withoutGlobalScope('active');
    }

    /**
     * Тред может иметь много ответов.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Тред может иметь лучший ответ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bestReply()
    {
        return $this->hasOne(Reply::class, 'thread_id');
    }

    /**
     * Добавляем ответ к треду.
     *
     * @param  array $reply
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Применяем все соответствующие фильтры для тредов.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Подписываем пользователя на текущий тред.
     *
     * @param  int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * Отписываем пользователя от текущего треда.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
     * Тред может иметь много подписок.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Проверяем, подписан ли данный пользователь на тред.
     *
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        if (! auth()->id()) {
            return false;
        }

        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Проверяем, был ли обновлен тред с того момента как пользователь его прочитал.
     *
     * @param  User $user
     * @return bool
     */
    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Получаем имена ключей маршрутов.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Доступ к атрибуту освного текста.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    /**
     * Установливаем правильный атрибут заголовка.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Помечаем данный ответ как лучший.
     *
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply)
    {
        if ($this->hasBestReply()) {
            $this->bestReply->owner->loseReputation('best_reply_awarded');
        }

        $this->update(['best_reply_id' => $reply->id]);

        $reply->owner->gainReputation('best_reply_awarded');
    }

    /**
     * Сбросываем записанный лучший ответ.
     */
    public function removeBestReply()
    {
        $this->bestReply->owner->loseReputation('best_reply_awarded');

        $this->update(['best_reply_id' => null]);
    }

    /**
     * Проверяем, есть ли у треда лучший ответ.
     *
     * @return bool
     */
    public function hasBestReply()
    {
        return ! is_null($this->best_reply_id);
    }

    /**
     * Получаем индексированный массив данных для модели.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
