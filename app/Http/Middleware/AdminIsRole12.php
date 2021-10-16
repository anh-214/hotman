<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminIsRole12
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            if (Auth::guard('admin')->user()->role =='1' || Auth::guard('admin')->user()->role =='2'){
                return $next($request);
            }
            abort(403);
        } 
        // else {
        //     return back();
        // }
        abort(403);
    }
}
