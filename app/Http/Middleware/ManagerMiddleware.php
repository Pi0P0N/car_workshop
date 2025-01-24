<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== RolesEnum::Manager->value) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
