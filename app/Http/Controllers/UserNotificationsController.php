<?php

namespace App\Http\Controllers;

class UserNotificationsController extends Controller
{
    /**
     * Создает новый экземпляр контроллера.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Получить все непрочитанные уведомления для пользователя.
     *
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Отметить конкретное уведомление как прочитанное.
     *
     * @param \App\User $user
     * @param int       $notificationId
     */
    public function destroy($user, $notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);

        $notification->markAsRead();

        return json_encode(
            $notification->data
        );
    }
}
