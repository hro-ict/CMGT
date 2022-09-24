<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\Articles;
use App\Models\Comments;
use Illuminate\Support\Facades\Hash;

class News extends Controller
{
    public function index() {
        $titles= Articles::orderBy('id', 'desc')->get();
        return view("news", ["titles"=>$titles]);
    }

    public function test (){
        $titles= Articles::orderBy('id', 'desc')->get();
        return view("test", ["titles"=>$titles]);
    }

    public function articles() {
        return view("news");
    }
    // public function login() {
    //     return view('login');
       
    // }

    public function register() {
        return view("register");
    }

    public function login(Request $request){
        $username= $request->username;
        $password= $request->password;

  
        

       
        if (Users::where('username', $username)->exists()) {
            $data= Users::where("username", $username)->get()[0];
            // $check_pass= Users::where("password", Hash::make($password));
            // print_r($check_pass);die();
            
 
            if (md5($password)==$data->password){
                $login_count= $data->login_count;
                Users::where('username',$username)->update([
                    "login_count"=>$login_count+1
                  ]);
                $session_data= array(
                    "username"=>$username,
                    "name"=>$data->firstname." ".$data->lastname,
                    "foto"=>$data->foto,
                    "role"=>$data->role,
                    "login_count"=> $login_count+1
                );
               
                

                Session::put("session", $session_data);


               return redirect()->to("/");
        
            }  
            else{
                return redirect()->to("/login")->with(["message"=>"login is failed"]);  
             }  
         }
        else{
           return redirect()->to("/login")->with(["message"=>"login is failed"]);  
        }
       
        // Session::forget("username");

    }

    public function logout(){
        Session::forget("session");
        return redirect()->to('/');
    }
    
    public function save_register(Request $request){
        $firstname= htmlspecialchars($request->firstname);
        $lastname= htmlspecialchars($request->lastname);
        $email= htmlspecialchars($request->email);
        $password=  htmlspecialchars(md5($request->password));
        $username= htmlspecialchars(strtolower($request->username));
        $role= "author";
        $login_count=0;
        if ($request->foto){
            $foto= $username.".png";
            $request->foto->move(public_path('images'), $foto);
        }
        else {
            $foto= "user.png";  
        }
       
 
     
         
         $request->validate([
             "firstname"=>"required|max:50|min:2",
             "lastname"=>"required|max:50|min:2",
             "email"=>"required|email|unique:users",
             "password"=>"required|min:6|max:10|confirmed",
             "username"=>"required|unique:users|min:4|max:15",
             "password"=>"required"

             ]);
        $data= compact("firstname","lastname","email","password","username","foto","role", 'login_count');
             
         Users::create($data);
         return redirect()->to("/login");
        
    }

    // public function create(){
    //     $data= array(
    //         "firstname"=>"yasar",
    //         "lastname"=>"unlu",
    //         "email"=>"yasar@gmail.com",
    //         "username"=>"yasar",
    //         "password"=>md5("password"),
    //         "foto"=>"foto.png",
    //         "role"=>"author"
    //     );
    //     Users::create($data);
    // }

    public function save_article(Request $request){
        $title= $request->title;
        $category= $request->category;
        $author_username= $request->author_username;
        $author_name= $request->author_name;
        $time= date("d-m-Y");
        $text= $request->text;
       
     


        if ($request->foto){
            $foto= $request->title.".png";
            $request->foto->move(public_path('images'), $foto);
        }
        else {
            $foto= "article.png";  
        }



      
        // $request->foto->move(public_path('images'), $title.".png");

        $data= compact("title","category", "author_username","author_name","text", "foto", "time");
        // $data= array(
        //     "title"=>$title,
        //     "author_username"=>$author_username
        // );
        
        Articles::create($data);
        return view("create_article")->with(["message"=>"success"]);

    }

    public function get_article($id){
        $article_data= Articles::where("id", $id)->get()[0];
        
        // print_r($article_data->title);die();
        $title= $article_data->title;
        $text= $article_data->text;
        $author_name= $article_data->author_name;
        $category= $article_data->category;
        $created_at= $article_data->created_at;
        $foto= $article_data->foto;
        $data= compact("title","text","author_name", "category", "created_at","foto");

        $comment_data= Comments::where("title", $title)->get();
       

        return view("get_article", ["data"=>$data, "comment_data"=>$comment_data]);
       
    }

    public function save_comment(Request $request){
          $commentator_username= $request->username;
          $commentator_name= $request->name;
          $comment= $request->comment;
          $title= $request->title;
          $data= compact('commentator_username','commentator_name','comment','title');
          Comments::create($data);
          return redirect()->back();

         

    }

    public function delete_comment(Request $request){
           $id= $request->id;
           Comments::where('id', $id)->delete();
           return redirect()->back();
    }

    public function delete_article(Request $request){
        $id= $request->id;
        Articles::where('id', $id)->delete();
        return redirect()->back();
 }

    public function get_user_articles($username){
       
        $articles= Articles::where('author_username', $username)->get();

        if (Session::has('session') and Session::get('session')['username']==$username){
           return view('user_articles', ["articles"=>$articles]); 
        }
        else{
          return abort(404);  
        }
        
    }

    public function get_category(Request $request){
        if ($request->category){
            $category= $request->category;
            $data= Articles::where("category",$category )->get();
        // return $data;
             return response()->json($data);

        }
        if ($request->search){
            $category= $request->category;
            $data= Articles::get("text");
        // return $data;
             return response()->json($data);
        }
        
  

        

        
    }
}
