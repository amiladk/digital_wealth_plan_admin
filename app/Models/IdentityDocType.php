<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
     ];
 
    public $timestamps = false;
    protected  $table  = 'identity_doc_type';
}
