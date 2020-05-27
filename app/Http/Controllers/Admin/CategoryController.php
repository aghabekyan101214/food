<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Category;
use App\helpers\SlugHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    const FOLDER = "admin.categories";
    const TITLE = "Category";
    const ROUTE = "/admin/categories";

    public function __construct()
    {
        $this->middleware('category', ['only' =>
            [
                'show',
                'edit',
                'update',
                'destroy',
                'add_subcategory',
                'edit_subcategory',
                'delete_subcategory',
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::whereNull('parent_id')->where('admin_id', Auth::user()->id)->get();
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
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Create";
        return view(self::FOLDER . '.create', compact('title', 'route', "action"));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:categories',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = SlugHelper::slugify($request->name);
        $category->admin_id = Auth::user()->id;
        $category->save();

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = Category::where('parent_id', $category->id)->get();
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', 'category', "action", "data"));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Category      $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:100|unique:categories,name,' . $category->id,
        ]);

        $category->name = $request->name;
        $category->slug = SlugHelper::slugify($request->name);
        $category->save();

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(self::ROUTE);
    }


    /**
     * @param         $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_subcategory($id, Request $request)
    {
        $insertData = $request->subcategory;
        $arr = array();
        foreach ($insertData as $bin => $data) {
            $arr[$bin]['name'] = $data;
            $arr[$bin]['slug'] = SlugHelper::slugify($data);
            $arr[$bin]['parent_id'] = $id;
            $arr[$bin]['admin_id'] = Auth::user()->id;
            $arr[$bin]['created_at'] = Carbon::now();
            $arr[$bin]['updated_at'] = Carbon::now();
        }

        Category::insert($arr);

        return redirect(self::ROUTE . "/" . $id . "/edit");
    }

    /**
     * @param         $id
     * @param         $sub_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit_subcategory($id, $sub_id, Request $request)
    {
        $category = Category::find($sub_id);
        $category->name = $request->subcategory;
        $category->slug = SlugHelper::slugify($request->subcategory);
        $category->save();

        return redirect(self::ROUTE . "/" . $id . "/edit");
    }

    /**
     * @param $id
     * @param $sub_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete_subcategory($id, $sub_id)
    {
        Category::destroy($sub_id);
        return redirect(self::ROUTE . "/" . $id . "/edit");
    }


}
