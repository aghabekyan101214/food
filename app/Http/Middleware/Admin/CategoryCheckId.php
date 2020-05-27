<?php

namespace App\Http\Middleware\Admin;

use App\Admin\Category;
use Closure;
use Illuminate\Support\Facades\Auth;

class CategoryCheckId
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $category = $request->route()->parameter('category');
        $subcategory = $request->route()->parameters();

        if ($category != null) {
            if ($category->admin_id === Auth::user()->id) {
                return $next($request);
            }
        } else if (isset($subcategory['id'])) {
            if (Category::find($subcategory['id'])->admin_id === Auth::user()->id) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
