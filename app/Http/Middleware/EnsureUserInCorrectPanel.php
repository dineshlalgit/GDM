<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserInCorrectPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = strtolower(Auth::user()->role->name ?? '');
            $panel = $request->segment(1); // e.g., 'owner', 'admin', 'staff', 'user'

            // Only allow access to the correct panel
            if ($role && $panel !== $role) {
                return redirect("/{$role}");
            }
        }
        return $next($request);
    }
}
