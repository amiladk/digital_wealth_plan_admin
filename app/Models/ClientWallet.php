<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientWallet extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client',
        'currency_type',
        'cypto_network',
        'wallet_address',
    ];

    public $timestamps = false;

    protected $table = 'client_wallet';

    // public function client()
    // {
    //     return $this->hasOne(User::class,'id','client');
    // }

    public function currencyType()
    {
        return $this->hasOne(CurrencyType::class,'id','currency_type');
    }

    public function cyptoNetwork()
    {
        return $this->hasOne(CryptoNetwork::class,'id','cypto_network');
    }

}
