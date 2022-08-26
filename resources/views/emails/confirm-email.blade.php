@component('mail::message')
# Последний шаг

Нам нужно подтвердить ваш Email, чтобы удостовериться в том, что вы человек.

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Подтвердить Email
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent
