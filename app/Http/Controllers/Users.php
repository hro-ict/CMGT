<?php
namespace App\Listeners;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class Users extends Controller
{
    public function create_user(Request $request){
        $firstname= htmlspecialchars($request->firstname);
        $lastname= htmlspecialchars($request->lastname);
        $email= htmlspecialchars($request->email);
        $password=  htmlspecialchars(md5($request->password));
        $username= htmlspecialchars(strtolower($request->username));
        $role_id= 2;
        $created_at= date("d-m-Y");
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
             "username"=>"required|unique:users|min:5|max:15",
             "password"=>"required"

             ]);
        $data= compact("firstname","lastname","email","password","username","foto","role_id", "created_at");
             
         User::create($data);
         return redirect()->to("/login");
        

    }

    public function check_login(Request $request){
        $username= $request->username;
        $password= $request->password;

  
        

       
        if (Users::where('username', $username)->exists()) {
            $data= Users::where("username", $username)->get()[0];
            // $check_pass= Users::where("password", Hash::make($password));
            // print_r($check_pass);die();
            
 
            if (md5($password)==$data->password){
                $session_data= array(
                    "username"=>$username,
                    "name"=>$data->firstname." ".$data->lastname,
                    "foto"=>$data->foto,
                    "role"=>$data->role,
                    "login_count"=>$data->login_count
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
}
