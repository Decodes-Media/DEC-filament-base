<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackUserLastActive
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Filament::isServing()) {
            return $next($request);
        }

        if ($user = user('web')) {
            $user->last_active_at = now();
            $user->save();
        }

        return $next($request);
    }
}
