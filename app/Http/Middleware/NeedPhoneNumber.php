<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NeedPhoneNumber
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
        if (Auth::guard('web')->user()->phonenumber != null){
            return $next($request);
        } else {
            session()->flash('fail', 'Vui lòng thêm số điện thoại để tiếp tục');
            return back();
        }
    }
}
