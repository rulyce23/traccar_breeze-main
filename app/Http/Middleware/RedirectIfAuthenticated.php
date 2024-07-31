<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('login_status')) {
            $status = $request->cookie('login_status');
            if ($status == true) {
                return redirect()->route('dashboard');
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
