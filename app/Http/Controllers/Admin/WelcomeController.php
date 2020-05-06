<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //Path To the View Folder
    const FOLDER = "admin";
    //Resource Title
    const TITLE = "Admin Dashboard";
    //Resource Route
    const ROUTE = "/admin";

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = self::TITLE;
        return view(self::FOLDER.".index", compact('title'));
    }
}
