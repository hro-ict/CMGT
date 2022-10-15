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


// TEST ROUTES
Route::get("/db_test",[News::class, 'db_test'])->name('db_test');

Route::get("/test_cat",[News::class, 'test_cat'])->name('test_cat');
//TEST ROUTES



Route::get("/example", function(){
            return view("example");   
});



Route::get("/",[News::class, 'index']);
Route::get("/articles",[News::class, 'articles'])->name('articles');
Route::post("/check_login",[News::class, 'login'])->name('check_login');
Route::get("/register",[News::class, 'register'])->name('register');
Route::get("/create",[News::class, 'create'])->name('create');
Route::post("/save_register",[News::class, 'save_register'])->name('save_register');
Route::get("/logout",[News::class, 'logout'])->name('logout');
Route::get("/ses",[News::class, 'ses'])->name('ses');
Route::post("/save_article",[News::class, 'save_article'])->name('save_article');
Route::get("/get_article/{id}/{search?}",[News::class, 'get_article'])->name('get_article');
Route::post("/save_comment",[News::class, 'save_comment'])->name('save_comment');
Route::post("/delete_comment",[News::class, 'delete_comment'])->name('delete_comment');
Route::post("/delete_article",[News::class, 'delete_article'])->name('delete_article');
Route::get("/get_user_articles/{username}",[News::class, 'get_user_articles'])->name('get_user_articles');
Route::get("/reset_password/{password}/",[News::class, 'reset_password'])->name('reset_password');
Route::get("/change_pass", function(){
            if (Session::has('session')){
                        return view("change_pass"); 
            }
            else {
               abort(404);
            }
              
});
Route::get("/change_password/",[News::class, 'change_password'])->name('change_password');
Route::get("/update_password",[News::class, 'update_password'])->name('update_password');
Route::get("/get_category",[News::class, 'get_category'])->name('get_category');

Route::get("/get_all_users",[News::class, 'get_all_users'])->name('get_all_users');
Route::get("/get_all_articles",[News::class, 'get_all_articles'])->name('get_all_articles');

Route::any("/delete_user",[News::class, 'delete_user'])->name('delete_user');

Route::post("/update_comment",[News::class, 'update_comment'])->name('update_comment');
Route::post("/update_article",[News::class, 'update_article'])->name('update_article');
Route::post("/update_article_status",[News::class, 'update_article_status'])->name('update_article_status');
Route::post("/forgot_password",[News::class, 'forgot_password'])->name('forgot_password');

Route::get("/login", function(){
            return view("login");   
});

Route::get("/forgot_password", function(){
            return view("forgot_password");   
});

Route::get("/contact", function(){
            return view("contact");   
});

Route::get("/about_us", function(){
            return view("about_us");   
});

// Route::get("/create_article", function(){
//             if (Session::has('session')){
//                         return view('create_article'); 
//                      }
//                      else{
//                        return abort(404);  
//                      }
            
// });

Route::get("/write_article",[News::class, 'write_article'])->name('write_article');
// Route::get("/test", function(){
//             return view("test");   
// });

Route::get("/test",[News::class, 'test'])->name('test');
Route::get("/send_mail",[News::class, 'send_mail'])->name('send_mail');


