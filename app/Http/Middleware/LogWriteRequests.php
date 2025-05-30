<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogWriteRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $user = $request->user();
            $userId = $user ? $user->id : null;

            Log::info('Write API Request', [
                'user_id' => $userId ?? 'guest',
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'status' => $response->getStatusCode(),
                'ip' => $request->ip(),
                'payload' => $request->except(['password', 'password_confirmation']),
            ]);
        }

        return $response;
    }
}
