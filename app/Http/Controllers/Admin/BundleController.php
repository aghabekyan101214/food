<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Bundle;
use App\Admin\BundleProduct;
use App\Admin\Product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BundleController extends Controller
{

    //Path To the View Folder
    const FOLDER = "admin.bundles";
    //Resource Title
    const TITLE = "Bundles";
    //Resource Route
    const ROUTE = "/admin/bundles";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Bundle::where('admin_id', Auth::user()->id)->get();
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
        $product = Product::with('category')->whereHas('category', function ($query) {
            $query->where('admin_id', Auth::user()->id);
        })->get();

        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . '.create', compact('title', 'route', 'action', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "product" => "required|array",
            "quantity" => "required|array",
            "name" => "required",
            "price" => "required|numeric",
        ]);

        $bundle = new Bundle;
        $bundle->name = $request->name;
        $bundle->price = $request->price;
        $bundle->admin_id = Auth::user()->id;
        $bundle->save();

        $arr = array();
        foreach ($request->product as $bin=>$key){
            $arr[$bin]['product_id'] = $key;
            $arr[$bin]['bundle_id'] = $bundle->id;
            $arr[$bin]['quantity'] = $request->quantity[$bin];
        }

        $bundle->attachedProducts()->createMany($arr);

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Bundle $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Bundle $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundle $bundle)
    {
        $product = Product::with('category')->whereHas('category', function ($query) {
            $query->where('admin_id', Auth::user()->id);
        })->get();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'action', 'bundle', 'product'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Bundle        $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {
        $request->validate([
            "product" => "required|array",
            "quantity" => "required|array",
            "name" => "required",
            "price" => "required|numeric",
        ]);

        DB::beginTransaction();

        $bundle->name = $request->name;
        $bundle->price = $request->price;
        $bundle->save();

        BundleProduct::where('bundle_id', $bundle->id)->delete();

        $arr = array();
        foreach ($request->product as $bin=>$key){
            $arr[$bin]['product_id'] = $key;
            $arr[$bin]['bundle_id'] = $bundle->id;
            $arr[$bin]['quantity'] = $request->quantity[$bin];
        }
        $bundle->attachedProducts()->createMany($arr);

        DB::commit();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Bundle $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        Bundle::destroy($bundle->id);
        return redirect(self::ROUTE);
    }
}
