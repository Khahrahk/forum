<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    /**
     * Не применяем автоматическую защиту.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Получаем модель, которая была добавлена ​​в избранное.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
