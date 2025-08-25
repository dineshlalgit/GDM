<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectToRoleDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only redirect after login
        if (Auth::check() && $request->is('owner/login')) {
            $role = Auth::user()->role->name ?? null;
            switch ($role) {
                case 'Owner':
                    return redirect('/owner');
                case 'Admin':
                    return redirect('/admin');
                case 'Staff':
                    return redirect('/staff');
                case 'User':
                    return redirect('/user');
                default:
                    return redirect('/owner');
            }
        }

        return $response;
    }
}
