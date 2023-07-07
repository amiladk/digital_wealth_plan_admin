<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'is_active',
    ];

    public $timestamps = false;

    protected $table = 'currency_type';

    public function networkMap()
    {
        return $this->hasMany(CurrencyNetworkMap::class,'currency_type','id');
    }

}
