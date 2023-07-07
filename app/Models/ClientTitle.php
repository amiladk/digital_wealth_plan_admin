<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTitle extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'title',
     ];
 
     public $timestamps = false;
     protected  $table = 'client_title';
}
