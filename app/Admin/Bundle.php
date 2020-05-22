<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{

    public function attachedProducts()
    {
        return $this->hasMany("App\Admin\BundleProduct", "bundle_id", "id");
    }


    public function products()
    {
        return $this->hasManyThrough("App\Admin\Product", "App\Admin\BundleProduct", "bundle_id", "id", "id", "product_id");
    }

}
