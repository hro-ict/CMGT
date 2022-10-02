<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;

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
    return view('articles');
});


Route::get("/login", function(){
  return view("login");
});
Route::get("/register", function(){
    return view("register");
});

Route::post("/create_user",[Users::class, 'create_user'])->name('create_user');
