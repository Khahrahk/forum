<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Определите, разрешен ли пользователю этот запрос..
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Reply);
    }

    /**
     * Обработка неудачной попытки авторизации.
     *
     * @return void
     *
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException(
            'Вы слишком часто отвечаете. Пожалуйста, сделайте перерыв.'
        );
    }

    /**
     * Получите правила проверки, применимые к запросу.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree'
        ];
    }
}
