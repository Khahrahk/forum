<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Не применяем автоматическую защиту.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Аксессоры для добавления к форме массива модели.
     *
     * @var array
     */
    protected $appends = ['favoritedModel'];

    /**
     * Получаем связанную тему для действий.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Получите записанную модель для избранной темы.
     */
    public function getFavoritedModelAttribute()
    {
        $favoritedModel = null;

        if ($this->subject_type === Favorite::class) {
            $subject = $this->subject()->firstOrFail();

            if ($subject->favorited_type == Reply::class) {
                $favoritedModel = Reply::find($subject->favorited_id);
            }
        }

        return $favoritedModel;
    }

    /**
     * Получить обратную связь активности для данного пользователя.
     *
     * @param  User $user
     * @return \Illuminate\Database\Eloquent\Collection;
     */
    public static function feed($user)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->paginate(30);
    }
}
