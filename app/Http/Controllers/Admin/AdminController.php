<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Admin\Admin;
use App\Mail\AdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{

    //Path To the View Folder
    const FOLDER = "admin.admins";
    //Resource Title
    const TITLE = "Admin";
    //Resource Route
    const ROUTE = "/admin/admins";

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::where('role', Admin::ROLE['admin'])->get();
        $title = self::TITLE;
        $route = self::ROUTE;
        return view(self::FOLDER . ".index", compact('title', 'route', 'data'));
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
            "name" => "required",
            "email" => "required|unique:admins,email",
            "password" => "required|min:6",
        ]);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = Admin::ROLE['admin'];
        $admin->save();

//        if ($admin->id) {
//            $details = [
//                'title' => 'Your password in Agarak admin panel.',
//                'body' => "Your password is` $request->password",
//            ];
//            Mail::to($request->email)->send(new AdminMail($details));
//        }

        return redirect(self::ROUTE);
    }

    /**
     * Display the specified resource.
     * @param \App\Admin\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Admin\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $title = self::TITLE;
        $route = self::ROUTE;
        $action = "Edit";
        return view(self::FOLDER . '.edit', compact('title', 'route', "action", 'admin'));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param \App\Admin\Admin         $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|unique:admins,email," . $admin->id,
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = Admin::ROLE['admin'];
        $admin->save();

//        if ($admin->id) {
//            $details = [
//                'title' => 'Your password in Agarak admin panel.',
//                'body' => "Your password is` $request->password",
//            ];
//            Mail::to($request->email)->send(new AdminMail($details));
//        }

        return redirect(self::ROUTE);
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Admin\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Admin::destroy($admin->id);
        return redirect(self::ROUTE);
    }
}
