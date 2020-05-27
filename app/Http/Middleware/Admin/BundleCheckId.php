<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class BundleCheckId
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
        $bundle = $request->route()->parameter('bundle');

        if ($bundle != null) {
            if ($bundle->admin_id === Auth::user()->id) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
