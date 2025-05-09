<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = 'customer')
    {
        //        dd(auth('customer')->user()->role);
        if (auth()->guard($guard)->check() && auth('customer')->user()->role->contains('slug', 'admin')) {
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }

    // public function handle(Request $request, Closure $next, $role, $permission = null)
    // {
    //     if (!$request->user()->hasRole($role)) {
    //         abort(404);
    //     }

    //     if ($permission !== null && !$request->user()->can($permission)) {
    //         abort(404);
    //     }

    //     return $next($request);
    // }
}
