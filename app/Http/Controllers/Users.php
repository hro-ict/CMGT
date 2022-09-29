<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
             
         Users::create($data);
         return redirect()->to("/login");
        

    }
}
