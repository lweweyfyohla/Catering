<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSupplier
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(Auth::check() && Auth::user()->isSupplier(), 403);

        return $next($request);
    }
}
