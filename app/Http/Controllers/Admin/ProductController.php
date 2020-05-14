<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\Admin\Product;
use App\Admin\ProductsImage;
use App\helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    const FOLDER = "admin.products";
    const TITLE = "Product";
    const ROUTE = "/admin/products";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with(['image', 'category'])->get();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . '.index', compact('title', 'route', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::with('childrenCategories')->whereNull('parent_id')->get();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . '.create', compact('title', 'route', "action", "category"));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'images' => 'required|array',
            'description' => 'required',
            'price' => 'required',
            'measure' => 'required',
            'quantity' => 'required',
        ]);

        $images = FileUploadHelper::upload($request->images, ["*"], "products");

        DB::beginTransaction();

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->measure = $request->measure;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();

        $product->image()->createMany($images);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = Category::all();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'category', "action", "product"));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Product       $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'images' => 'array',
            'description' => 'required',
            'price' => 'required|numeric',
            'measure' => 'required',
            'quantity' => 'required',
        ]);

        if (!empty($request->images)) {
            $images = FileUploadHelper::upload($request->images, ["*"], "products");
        } else {
            $images = array();
        }

        DB::beginTransaction();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->measure = $request->measure;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();

        $product->image()->createMany($images);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $images = ProductsImage::where('product_id', $product->id)->get();
        foreach ($images as $key){
            Storage::delete("$key->image");
        }
        Product::destroy($product->id);

        return redirect(self::ROUTE);
    }



    public function destroy_image($product, $id)
    {
        $image = ProductsImage::find($id);
        Storage::delete("$image->image");
        ProductsImage::destroy($image->id);
        return redirect(self::ROUTE . '/' . $product . '/edit');
    }

}
