<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * Laravel's default RedirectIfAuthenticated always sends logged-in
     * visitors of /login to the route named "dashboard" (the customer
     * dashboard), regardless of their role. That means an already-logged-in
     * admin or supplier who lands on /login gets bounced to /dashboard and
     * 403'd by the role middleware. This version redirects based on the
     * user's actual role instead.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect($this->redirectPathFor(Auth::guard($guard)->user()));
            }
        }

        return $next($request);
    }

    private function redirectPathFor($user): string
    {
        return match ($user->role) {
            'supplier' => route('supplier.quotations.index'),
            'admin' => route('admin.dashboard'),
            default => route('dashboard'),
        };
    }
}