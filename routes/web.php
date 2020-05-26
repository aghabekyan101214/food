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
Route::get('/', function () {
    return redirect("/admin");
});


//Admin dashboard part
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

//user registration and login part
Route::get('/login/user', 'Auth\LoginController@showUserLoginForm');
Route::post('/login/user', 'Auth\LoginController@userLogin');
Route::get('/register/user', 'Auth\RegisterController@showUserRegisterForm');
Route::post('/register/user', 'Auth\RegisterController@createUser');

//user pages part
Route::group(['namespace' => 'Site', 'prefix' => 'user', 'middleware' => 'auth:user'], function () {
    Route::get('/', 'UserController@index')->name('account');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', 'WelcomeController@index');

//for super admin links
    Route::group(['middleware' => 'superAdmin'], function () {
        Route::resource('/admins', 'AdminController');
    });

//for admin (clients) links
    Route::group(['middleware' => 'admin'], function () {
        Route::resource('/users', 'UserController');

//categories
        Route::resource('/categories', 'CategoryController');
        Route::post('/categories/{id}/subcategory', 'CategoryController@add_subcategory');
        Route::delete('/categories/{id}/delete/{sub_id}', 'CategoryController@delete_subcategory');
        Route::put('/categories/{id}/edit/{sub_id}', 'CategoryController@edit_subcategory');

//products
        Route::resource('/products', 'ProductController');
        Route::delete('/products/{products_id}/destroy-image/{id}', 'ProductController@destroy_image');

//bundles
        Route::resource('/bundles', 'BundleController');
    });

});
