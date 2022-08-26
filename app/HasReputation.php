<?php

namespace App;

trait HasReputation
{
    /**
     * Награждаем модель очками репутации.
     *
     * @param  string $action
     */
    public function gainReputation($action)
    {
        $this->increment('reputation', config("council.reputation.{$action}"));
    }

    /**
     * Уменьшаем очки репутации для модели.
     *
     * @param  string $action
     */
    public function loseReputation($action)
    {
        $this->decrement('reputation', config("council.reputation.{$action}"));
    }
}
