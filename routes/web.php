<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function(){
    return redirect("/admin");
});



//Admin dashboard part
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {

//    for super admin links
    Route::group(['middleware' => 'superAdmin'], function () {
        Route::resource('/admins', 'AdminController');
    });

    Route::get('/', 'WelcomeController@index');

//categories
    Route::resource('/categories', 'CategoryController');
    Route::post('/categories/{id}/subcategory', 'CategoryController@add_subcategory');
    Route::delete('/categories/{id}/delete/{sub_id}', 'CategoryController@delete_subcategory');
    Route::put('/categories/{id}/edit/{sub_id}', 'CategoryController@edit_subcategory');

//products
    Route::resource('/products', 'ProductController');
    Route::delete('/products/{products_id}/destroy-image/{id}', 'ProductController@destroy_image');

    Route::resource('/bundles', 'BundleController');
});
