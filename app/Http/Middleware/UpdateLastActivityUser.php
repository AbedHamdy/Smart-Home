<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActivityUser
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
            if ($user->userable_type === Client::class && $user->userable)
            {
                $user->userable->update(['last_activity' => now()]);
                // dd($user->userable);
            }
        }

        return $response;
    }
}
