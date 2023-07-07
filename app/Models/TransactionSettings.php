<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'field',
        'value'
     ];
 
     public $timestamps = false;
     protected  $table = 'transaction_settings';
}
