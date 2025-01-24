<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== RolesEnum::Employee->value) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}