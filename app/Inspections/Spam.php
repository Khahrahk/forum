<?php

namespace App\Inspections;

class Spam
{
    /**
     * Все зарегистрированные проверки.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class
    ];

    /**
     * Обнаруживает спам.
     *
     * @param  string $body
     * @return bool
     */
    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
