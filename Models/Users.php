<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    protected $table="users";
    protected $fillable= ["firstname", "lastname","email","username","password","foto", "role","created_at","updated_at"];
}