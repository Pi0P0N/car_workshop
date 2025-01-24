<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfClientsDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $clientId = $request->route('id');

        if ($user->id == $clientId || (RolesEnum::isWorkingHere() && $user->role == RolesEnum::Customer->value)) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
