<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin\Admin;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user() &&  Auth::user()->role == Admin::ROLE['super']) {
            return $next($request);
        }

        return redirect('/admin');
    }
}
