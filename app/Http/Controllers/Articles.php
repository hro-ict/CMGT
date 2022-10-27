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

class Articles extends Controller
{
    
    public function index() {
    $titles= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
        
    return view("test", ["titles"=>$titles]);
    }
    
    
      public function test (){
        $titles= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
        
        return view("test", ["titles"=>$titles]);
    }

    public function articles() {
        return view("news");
    }
    
    public function write_article(){
    if (Session::has('session')){
     $comment_count= Users::find(Session::get('session')['id'])->get_user_comments->count();
      return view("create_article", ["comment_count"=>$comment_count]);
    }
    else {
        return abort(404); //return 404 page
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

        $data= compact("title","category_id", "user_id","text", "foto", "status");
        Articles::create($data);
        return view("create_article")->with(["message"=>"success"]);

    }
    
    //get article text with id or with search function
    public function get_article($id, $search= null){
       
        $article_data= Articles::where("id", $id)->with('get_user')->get()[0];
        $title= $article_data->title;
        $text= $article_data->text;
        $author_name= $article_data->get_user->firstname." ".
        $article_data->get_user->lastname;
        $author_username= $article_data->get_user->username;
        $created_at= $article_data->created_at;
        $foto= $article_data->foto;
        $data= compact("title","text","author_name", "author_username", "created_at","foto");
        $comment_data= Comments::with("get_user")-> where("title", $title)->get();
        return view("get_article", ["data"=>$data, "comment_data"=>$comment_data, "search"=>$search]);
       
    }
    
    public function save_comment(Request $request){
         $request->validate([
             "comment"=>"required|max:500|min:5"
             ]);
          $user_id= $request->user_id;
          $title= $request->title;
          $article_id= Articles::where("title", $title)->get()[0]->id;
          $comment= htmlspecialchars($request->comment);
          $data= compact('user_id','article_id','title','comment');
          Comments::create($data);
          return redirect()->back();
    }
    
    //comment edit
     public function update_comment(Request $request){
        $id= $request->comment_id;
        $comment= $request->comment_body;
        $result= Comments::where('id', $id)->update([
               "comment"=>$comment
               ]);
        return $result;
    }
    
     public function delete_comment(Request $request){
           $id= $request->id;
           Comments::where('id', $id)->delete();
           return redirect()->back();
    }
    
   //edit article
    public function update_article(Request $request){
        $id= $request->id;
        $body= $request->body;
        $result= Articles::where('id', $id)->update([
               "text"=>$body
               ]);
        return $result;
    }
      //update status of article (active or inactive)
    public function update_article_status(Request $request){
        $id= $request->id;
        $user_email= Articles::find($id)->get_user->email;
        $name= Articles::find($id)->get_user->lastname;
        $title= Articles::find($id)->title;
 
        $status= $request->status;
      
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
            
         //send mail to user about new status of article
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
        
        //send mail to User if article deleted
            if ($result==1){
            $data = array("name"=>$name, "title"=>$title); 
            
         Mail::send('mail_3', $data, function($message) use ($user_email) {
         $message->to($user_email, 'My Articles')->subject
            ('Your article removed');
         $message->from('admin@myarticles.com','Yasar Unlu');
      });
        }
        
        return $result;
 }

    //list of all articles on admin panel
    public function get_user_articles($username){
        if (Session::has('session')){
            $user_id= Session::get('session')["id"];
            $articles= Users::find($user_id)->get_user_articles;
            return view('user_articles', ["articles"=>$articles]);
       }
       else {
           return abort(404);
       }
       
    }

//search articles by tag- category
public function get_category(Request $request){
   if ($request->category){
    $category_id= Categories::where("category", $request->category)->get()[0]->id;
    $data= Articles::where('category_id', $category_id)->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
    return $data;
   }

   if ($request->search){
    $data= Articles::where('status', 'true')->with("get_user")->with('get_category')->orderBy('created_at', 'desc')->get();
    return $data;
   }
  }
  public function get_all_articles(){
       if (Session::has('session') and Session::get('session')['role']=="admin"){
        $articles= Articles::with("get_user")->get();

        return view("get_all_articles", ["articles"=>$articles]);
       }

       else {
        return abort(404);
       }
}



    
    
    
}
