<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Comments;
use App\Models\Tokens;
use Illuminate\Support\Facades\Hash;
use Mail;


use Carbon\Carbon;

class News extends Controller
{
    public function index() {
    // $titles= Articles::where("status", "true")->orderBy('created_at', 'desc')->get();
    //     return view("news", ["titles"=>$titles]);
    $titles= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
        
    return view("test", ["titles"=>$titles]);
    }

    public function test (){
        // $titles= Articles::where("status", "true")->orderBy('created_at', 'desc')->get();
        $titles= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
        
        return view("test", ["titles"=>$titles]);
    }

//get all articles

    public function articles() {
        return view("news");
    }
    // public function login() {
    //     return view('login');
       
    // }


//user register
    public function register() {
        return view("register");
    }

//user login check
    public function login(Request $request){
          $request->validate([
             "password"=>"required",
             "username"=>"required",
             ]);
        $username= $request->username;
        $password= $request->password;

        if (Users::where('username', $username)->exists()) {
            $data= Users::where("username", $username)->get()[0];
            $user_id= $data->id;
            $user= Users::find($user_id);
            $role= $user->get_role->role;
            $comment_count= $user->get_user_comments->count();
         
         
            if (md5($password)==$data->password){
                $session_data= array(
                    "id"=>$user_id,
                    "username"=>$username,
                    "name"=>$data->firstname." ".$data->lastname,
                    "foto"=>$data->foto,
                    "role"=>$role,
                    "comment_count"=>$comment_count
                );
                Session::put("session", $session_data);


               return redirect()->to("/");
        
            }  
            else{
                return view("/login", ["response"=>"failed"]) ;
             }  
         }
        else{
            return view("/login", ["response"=>"failed"]);  
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
        $role_id= 2;
        if ($request->foto){
            $foto= $username.".png";
            $request->foto->move(public_path('images'), $foto);
        }
        else {
            $foto= "user.png";  
        }
       
 
     
         //validation of fields
         $request->validate([
             "firstname"=>"required|max:50|min:2",
             "lastname"=>"required|max:50|min:2",
             "email"=>"required|email|unique:users",
             "password"=>"required|min:6|max:15|confirmed",
             "username"=>"required|unique:users|min:4|max:15",
            //  "foto"=>"mimes:jpeg,jpg,png,webp"
            // "foto"=>"image|mimes:jpeg,png,jpg,gif,webp"
           'foto'=> 'image|mimes:jpg,png,jpeg,gif,svg, webp|max:1024'
         

             ]);
        $data= compact("firstname","lastname","email","password","username","foto","role_id");
             
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
  
  
  //user create article
    public function write_article(){
        $all_comments= [];
        if (Session::has('session')&& Session::get('session')["role"]!="admin" ){
         $comment_count= Users::find(Session::get('session')['id'])->get_user_comments->count();
         $comments= Users::find(Session::get('session')['id'])->get_user_comments;

         if ($comment_count>0){
             foreach($comments as $comment){
            array_push($all_comments, $comment->article_id);
            
         } 
         return view("create_article", ["comment_count"=> count(array_unique($all_comments))]);
         
         }
          else {
             return view("create_article", ["comment_count"=> $comment_count]);
             
         }
        
          
        }
        else {
           return view("error"); 
        }
       
      

    }
    
    
     
    public function save_article(Request $request){
          $request->validate([
             "title"=>"required|max:100|min:10",
             "text"=> "required|max:5000|min:500"
             ]);
        $category_id= Categories::where("category", $request->category)->get()[0]->id;
        $user_id= Users::where("username", $request->author_username)->get()[0]->id;
        $title= $request->title;
        $text= $request->text;
        $status= "false";
       
        if ($request->foto){
            $foto= $request->title.".png";
            $request->foto->move(public_path('images'), $foto);
        }
        else {
            $foto= "article.png";  
        }



      
        // $request->foto->move(public_path('images'), $title.".png");

        $data= compact("title","category_id", "user_id","text", "foto", "status");
        // $data= array(
        //     "title"=>$title,
        //     "author_username"=>$author_username
        // );
        
        Articles::create($data);
        return view("create_article")->with(["message"=>"success"]);

    }

  //controller__articles
    public function get_article($id, $search= null){
          if (Articles::where('id', $id)->exists()){
              $article_data= Articles::where("id", $id)->with('get_user')->get()[0];
        if ($article_data->status=="true"){
        // print_r($article_data->title);die();
        $title= $article_data->title;
        $text= $article_data->text;
        $author_name= $article_data->get_user->firstname." ".
        $article_data->get_user->lastname;
        $author_username= $article_data->get_user->username;
        //$category= $article_data->category;
        $created_at= $article_data->created_at;
        $foto= $article_data->foto;
        $data= compact("title","text","author_name", "author_username", "created_at","foto");

        $comment_data= Comments::with("get_user")-> where("title", $title)->get();
       

        return view("get_article", ["data"=>$data, "comment_data"=>$comment_data, "search"=>$search]);
        }
        else {
          return view("error"); 
        } 
          }
        else {
          return view("error"); 
        }
       
       
    }


    public function save_comment(Request $request){
         $request->validate([
             "comment"=>"required|max:500|min:5",
             
             ]);
          $user_id= $request->user_id;
          $title= $request->title;
          $article_id= Articles::where("title", $title)->get()[0]->id;
      
        //   $commentator_username= $request->username;
        //   $commentator_name= $request->name;
          $comment= htmlspecialchars($request->comment);
          
        //   $title= $request->title;
          $data= compact('user_id','article_id','title','comment');
          Comments::create($data);
          return redirect()->back();

         

    }



    public function update_comment(Request $request){
        $id= $request->comment_id;
        $comment= $request->comment_body;
        $result= Comments::where('id', $id)->update([
               "comment"=>$comment
               ]);
        return $result;
        //   return redirect()->back();
    }
    

     public function delete_comment(Request $request){
           $id= $request->id;
           Comments::where('id', $id)->delete();
           return redirect()->back();
    }
    

    public function update_article(Request $request){
        $id= $request->id;
        $body= $request->body;
        $result= Articles::where('id', $id)->update([
               "text"=>$body
               ]);
        return $result;
        //   return redirect()->back();
    }
    

    public function update_article_status(Request $request){
        $id= $request->id;
        $user_email= Articles::find($id)->get_user->email;
        $name= Articles::find($id)->get_user->lastname;
        $title= Articles::find($id)->title;
 
        $status= $request->status;
      
      
        //check query
        $result= Articles::where('id', $id)->update([
               "status"=>$status
               ]);
        if ($result==1){

           if ($status=="false"){
               $data = array("name"=>$name, "status"=>"INACTIVE", "title"=>$title); 
           }
           else {
                $data = array("name"=>$name, "status"=>"ACTIVE", "title"=>$title); 
           }
            
         // send mail to user for information about status of article
         Mail::send('mail_2', $data, function($message) use ($user_email) {
         $message->to($user_email, 'My Articles')->subject
            ('Status your article');
         $message->from('admin@myarticles.com','Yasar Unlu');
      });
        }
        return $result;
    }

    public function delete_article(Request $request){
        $id= $request->id;
         $user_email= Articles::find($id)->get_user->email;
        $name= Articles::find($id)->get_user->lastname;
        $title= Articles::find($id)->title;
  
        $result= Articles::where('id', $id)->delete();
        
        //send mail to User
            if ($result==1){
            $data = array("name"=>$name, "title"=>$title); 
          
          // send mail to user for information
         Mail::send('mail_3', $data, function($message) use ($user_email) {
         $message->to($user_email, 'My Articles')->subject
            ('Your article removed');
         $message->from('admin@myarticles.com','Yasar Unlu');
      });
        }
        
        return $result;
        // return redirect()->back();
 }

  
    public function get_user_articles($username){
        if (Session::has('session')&& Session::get('session')["role"]!="admin"){
            $user_id= Session::get('session')["id"];
            $articles= Users::find($user_id)->get_user_articles;
            return view('user_articles_2', ["articles"=>$articles]);
       }
       else {
          return view("error"); 
       }
       
    }


  //controller__articles
public function get_category(Request $request){
   if ($request->category){
    $category_id= Categories::where("category", $request->category)->get()[0]->id;
    $data= Articles::where('category_id', $category_id)->with("get_user")->with('get_category')->with('get_comment')->orderBy('created_at', 'desc')->get();
    //$data= Articles::get();
    return $data;
   }

   if ($request->search){
    $data= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
    return $data;
   }
}


// test category


    // public function get_category(Request $request){

    //    if ($request->category){
    //     $category_id= Categories::where("category", $request->category)->get()[0]->id;
    //     $data= Articles::where('category_id', $category_id)->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
    //     //$data= Articles::get();
    //     return $data;
    //    }
    //     if ($request->search){
    //         $category= $request->search;
    //         // $data= Articles::get();
    //         $titles= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();

  
      
    //     // return $data;
    //         //  return response()->json($data1);
    //         return $data;
    //     }
        
    // }


  //get all users for admin panel
    public function get_all_users(){
       if (Session::has('session') and Session::get('session')['role']=="admin"){
        $users= Users::with("get_role")->orderBy('created_at', 'desc')->get();
       
    
        // print_r($users);die();

        return view("get_all_users", ["users"=>$users]);
       }

       else {
        return view("error"); 
        // return redirect()->to("/login");
       }
    
}

  //get all articles for admin panel
    public function get_all_articles(){
       if (Session::has('session') and Session::get('session')['role']=="admin"){
        $articles= Articles::with("get_user")->orderBy('created_at', 'desc')->get();

        return view("get_all_articles", ["articles"=>$articles]);
       }

       else {
        return view("error"); 
        //return redirect()->to("/login");
       }
    
}

  //controller__users
public function delete_user(Request $request){
   $id= $request->id;

   

   
  if($request->id){
    $id= $request->id;
    $query= Users::where('id', $id)->delete();
    Comments::where("user_id", $id)->delete();
    Articles::where("user_id", $id)->delete();
     return $query;
  }
  //if user log-in 
  else {
      if (Session::has('session')){
          $id= Session::get('session')["id"];
           $query= Users::where('id', $id)->delete();
           Comments::where("user_id", $id)->delete();
           Articles::where("user_id", $id)->delete();
           if ($query==1){
               Session::forget("session");
               return $query;
           }
      }
      
  }
    //return redirect()->back();

}


  //controller__users
public function forgot_password(Request $request){
    global $email;
    $email= $request->email;
    

     if (Users::where('email', $email)->exists()){
         $token= bin2hex(random_bytes(16));
         $user_id= Users::where("email", $email)->get()[0]->id;
         Tokens::create(compact("user_id", "token"));
        $data = array('link'=>"http://152.70.56.180:9001/reset_password/".$token);
         
         //send mail to user for password reset 
         Mail::send('mail', $data, function($message) use ($email) {
         $message->to($email, 'My Articles')->subject
            ('Reset your password');
         $message->from('admin@myarticles.com','Yasar Unlu');
      });
      
      return view("forgot_password",["response"=>"success"]);
       
     }
     else {
         return view("forgot_password",["response"=>"failed"]);
     }
 
    
}

// public function send_mail(){    
//     $token= bin2hex(random_bytes(16));
    
//      $data = array('link'=>"http://152.70.56.180:9001/reset_password/".$token);
//       Mail::send('mail_2', $data, function($message) {
//          $message->to('abc@gmail.com', 'Tutorials Point')->subject
//             ('Laravel HTML Testing Mail');
//          $message->from('xyz@gmail.com','Virat Gandhi');
//       });
//       echo "HTML Email Sent. Check your inbox.";
    
// }


  //
public function  reset_password($token){
    if (Tokens::where('token', $token)->exists()){
        $user_id= Tokens::where("token", $token)->get()[0]->user_id;
        Tokens::where("token", $token)->delete();
        return view("reset_password", ["user_id"=>$user_id]);
    } 
}

  //controller__users
public function change_password (Request $request){
    $password= $request->password;
    $current_password= $request->current_password;
    $request->validate([
        "current_password"=>"required",
        "password"=>"required|min:6|max:15|confirmed",
        ]);
    
        if (Session::has('session')){
            $user_id= Session::get('session')["id"];
 
            $user_password= Users::where("id",$user_id)->get()[0]->password;
            if ($user_password== md5($current_password)){
                $check= Users::where("id",$user_id)->update([
                    "password"=>md5($password)
                ]);
                return view("change_pass", ["response"=>$check]);
            }
            else {
                return view("change_pass", ["response"=>"Current password is not correct"]);
            }
            
        }

}

  //controller__users
public function update_password(Request $request){
    $id= $request->user_id;
    
    $request->validate([
        "password"=>"required|min:6|max:15|confirmed",
        ]);

        Users::find($id)->update([
            "password"=>md5($request->password)
        ]);
        return view("login", ["response"=>"success"]);

}

public function db_test (){
    $users= Articles::with("get_user")->get();
    return response()->json($users);
    // print_r($users);die();
    // return view('db_test', ["users"=>$users]);
    //return md5("admin.2022");
    // $user= Users::find(1)->get_role->role;
    // dd($user);
    // $role= $user->get_role;
    // echo $role->role;
    
    // $art= Articles::find(2);
    // print_r($art->get_user->username);
    
    
    // foreach ($articles as $article){
    //     print_r($article->title);
    // }
}


public function post_test (Request $request) {
    // $req= $request->postName;
    // return response()->json(["message"=>$req]);
  
    $users= Users::all()->first();
    // return response()->json($users);
    $carb= Carbon::parse($users->created_at)->format("d M l y h:m ");
    return $carb;
    // print_r($users);
    
    
    
}



}


