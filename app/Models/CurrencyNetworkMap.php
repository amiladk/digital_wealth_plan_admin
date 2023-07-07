<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyNetworkMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'currency_type',
        'crypto_network',
    ];

    public $timestamps = false;

    protected $table = 'currency_network_map';

    public function cryptoNetwork()
    {
        return $this->hasOne(CryptoNetwork::class,'id','crypto_network');
    }
}
