<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * Все зарегистрированные недействительные слова.
     *
     * @var array
     */
    protected $keywords = [
        'oof'
    ];

    /**
     * Обнаруживает спам.
     *
     * @param  string $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Ваш ответ содержит спам.');
            }
        }
    }
}
