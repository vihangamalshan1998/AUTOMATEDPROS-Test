<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        $userId = optional($request->user())->id;
        Log::info('api.request', [
            'user_id'   => $userId,
            'method'    => $request->method(),
            'uri'       => $request->path(),
            'timestamp' => now()->toDateTimeString(),
        ]);
        return $next($request);
    }
}
