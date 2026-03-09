<?php

// This middleware checks if the authenticated user is an admin before allowing access to certain routes. If the user is not authenticated, it returns a 401 Unauthenticated response. If the user is authenticated but not an admin, it returns a 403 Access Denied response. If the user is an admin, it allows the request to proceed to the next middleware or controller.
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Get the currently authenticated user. If there is no authenticated user, return a 401 Unauthenticated response. If the user is authenticated but does not have admin privileges, return a 403 Access Denied response. If the user is an admin, allow the request to proceed to the next middleware or controller.    
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        if (!$user->isAdmin()) {
            return response()->json([
                'message' => 'Access denied. Admins only.'
            ], 403);
        }

        return $next($request);
    }
}