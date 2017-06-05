<?php

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
    return view('welcome');
});



Route::get('login', function () {
    return redirect('/admin/login');
});
Route::get('register', function () {
    return redirect('/admin/register');
});



Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'role:admin,access_backend'], 'namespace' => 'Admin'], function () {
    // Backpack\NewsCRUD
    CRUD::resource('article', 'ArticleCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('tag', 'TagCrudController');
});
