<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\News;

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

Route::get("/",[News::class, 'index']);
Route::get("/articles",[News::class, 'articles'])->name('articles');
Route::post("/check_login",[News::class, 'login'])->name('check_login');
Route::get("/register",[News::class, 'register'])->name('register');
Route::get("/create",[News::class, 'create'])->name('create');
Route::post("/save_register",[News::class, 'save_register'])->name('save_register');
Route::get("/logout",[News::class, 'logout'])->name('logout');
Route::get("/ses",[News::class, 'ses'])->name('ses');
Route::post("/save_article",[News::class, 'save_article'])->name('save_article');
Route::get("/get_article/{id}",[News::class, 'get_article'])->name('get_article');
Route::post("/save_comment",[News::class, 'save_comment'])->name('save_comment');



Route::get("/login", function(){
            return view("login");   
});

Route::get("/create_article", function(){
            return view("create_article");   
});


