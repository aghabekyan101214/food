<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function categories()
    {
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, "parent_id", "id")->with('categories');
    }

}
