<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Category;
use App\Admin\Admin\ProductsImage;

class Product extends Model
{

    const MEASURE = array(
        "piece" => 1,
        "kilogram" => 2,
    );

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function image()
    {
        return $this->hasMany("App\Admin\ProductsImage", 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo("App\Admin\Category", 'category_id', 'id');
    }
}
