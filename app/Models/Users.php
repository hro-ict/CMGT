<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Articles;
use App\Models\Comments;

class Users extends Model
{
    use HasFactory;
    protected $table="users";
    protected $fillable= ["firstname", "lastname","email","username","password","foto", "role_id", "created_at","updated_at"];
    
    public function get_user_articles(){
        return $this->hasMany(Articles::class, "user_id");
        
    }
    
     public function get_user_comments(){
        return $this->hasMany(Comments::class, "user_id");
        
    }
    
    public function get_role(){
        return $this->hasOne(Roles::class, "id", "role_id");
    }

    public function get_user_token(){
        return $this->hasOne(Tokens::class, "id", "user_id");

    }
}

