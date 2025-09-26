<?php
namespace App\Http\Middleware;

class RoleMiddleware
{
    public function handle($request, \Closure $next, $roles)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $allowed = explode('|', $roles);
        if (! in_array($user->role, $allowed)) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
