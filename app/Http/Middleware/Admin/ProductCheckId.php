<?php

namespace App\Http\Middleware\Admin;

use App\Admin\Category;
use App\Admin\Product;
use Closure;
use Illuminate\Support\Facades\Auth;

class ProductCheckId
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $product = $request->route()->parameter('product');
        $image = $request->route()->parameters();

        if ($product != null) {
            if (Category::find($product->category_id)->admin_id === Auth::user()->id) {
                return $next($request);
            }
        } else if (isset($image['products_id'])) {
            $product = Product::find($image['products_id']);
            if (Category::find($product->category_id)->admin_id === Auth::user()->id) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
