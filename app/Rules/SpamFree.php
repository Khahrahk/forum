<?php

namespace App\Rules;

use Exception;
use App\Inspections\Spam;

class SpamFree
{
    /**
     * Определяем, проходит ли данный атрибут проверку на спам.
     *
     * @param  string $attribute
     * @param  string $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return ! resolve(Spam::class)->detect($value);
        } catch (Exception $e) {
            return false;
        }
    }
}
