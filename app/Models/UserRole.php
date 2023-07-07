<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'user_role',
        'description'
     ];
 
     public $timestamps = false;
     protected  $table = 'user_role';
}
