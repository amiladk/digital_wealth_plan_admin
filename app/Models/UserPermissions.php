<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'role_id',
        'permission',
        
     ];

    public $timestamps = false;
    protected  $table = 'user_permissions';
}
