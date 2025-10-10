<?php

namespace App\Http\Middleware;

use App\Models\Technician;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivityTechnician
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($user = $request->user())
        {
            if ($user->userable_type === Technician::class && $user->userable)
            {
                $user->userable->update(['last_activity' => now()]);
            }
        }

        return $response;
    }
}
