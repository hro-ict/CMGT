<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $table="articles";
    protected $fillable= ["title", "category","author_username","author_name","text","foto","created_at","updated_at"];
}
