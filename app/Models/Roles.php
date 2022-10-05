<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    pretected $table= "roles";
    protected $fillable= ["role", "created_at", "created_at" "updated_at"];
}
