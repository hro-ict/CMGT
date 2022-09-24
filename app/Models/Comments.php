<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table="comments";
    protected $fillable= ["title", "comment","commentator_username","commentator_name","created_at","updated_at"];
}
