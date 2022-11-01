<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table="comments";
    protected $fillable= ["user_id", "article_id","comment","title","created_at","updated_at"];

    public function get_user() {
        return $this->belongsTo(Users::class, "user_id");
    }
}
