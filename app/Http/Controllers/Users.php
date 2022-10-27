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

class Users extends Controller
{
    
       public function register() {
        return view("register");
    }
    
    
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
        Session::forget("session"); //end session if user logout
        return redirect()->to('/');
    }

    //register user
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
       
 
     
         
         $request->validate([
             "firstname"=>"required|max:50|min:2",
             "lastname"=>"required|max:50|min:2",
             "email"=>"required|email|unique:users",
             "password"=>"required|min:6|max:15|confirmed",
             "username"=>"required|unique:users|min:4|max:15",
         

             ]);
        $data= compact("firstname","lastname","email","password","username","foto","role_id");
             
         Users::create($data);
         return redirect()->to("/login");
        
    }
    
    //list all user on admin panel
    public function get_all_users(){
       if (Session::has('session') and Session::get('session')['role']=="admin"){
        $users= Users::with("get_role")->orderBy('created_at', 'desc')->get();
       
    
        // print_r($users);die();

        return view("get_all_users", ["users"=>$users]);
       }

       else {
        return abort(404);
        // return redirect()->to("/login");
       }
       
   public function delete_user(Request $request){
   $id= $request->id;
  if($request->id){
    $id= $request->id;
    $query= Users::where('id', $id)->delete();
    Comments::where("user_id", $id)->delete(); //delete user comments
    Articles::where("user_id", $id)->delete(); // delete user articles
     return $query;
  }
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



public function forgot_password(Request $request){
    global $email;
    $email= $request->email;
    
      //send mail to user for password recovery
     if (Users::where('email', $email)->exists()){
         $token= bin2hex(random_bytes(16));
         $user_id= Users::where("email", $email)->get()[0]->id;
         Tokens::create(compact("user_id", "token"));
        $data = array('link'=>"http://152.70.56.180:9001/reset_password/".$token);
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
     
     public function  reset_password($token){
    if (Tokens::where('token', $token)->exists()){
        $user_id= Tokens::where("token", $token)->get()[0]->user_id;
        Tokens::where("token", $token)->delete();
        return view("reset_password", ["user_id"=>$user_id]);
    } 
}


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
    
}
    
}
        
}
