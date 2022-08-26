<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfEmailNotConfirmed
{
    /**
     * Обработка входящего запроса.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (! $user->confirmed && ! $user->isAdmin()) {
            return redirect('/threads')
                ->with('flash', 'Для начала вы должны подтвердить ваш Email.');
        }

        return $next($request);
    }
}
