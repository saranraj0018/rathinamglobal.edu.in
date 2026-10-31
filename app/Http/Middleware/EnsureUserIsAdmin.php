<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards /admin: guests go to the admin login, signed-in non-admins get 403.
 */
class EnsureUserIsAdmin
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->guest(route('admin.login'));
        }

        abort_unless($user->is_admin, 403);

        return $next($request);
    }
}
