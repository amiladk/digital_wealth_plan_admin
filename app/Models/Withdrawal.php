<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
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
        'status',
        'currency_type',
        'cypto_network',
        'wallet_address',
        'withdraw_amount',
        'transaction_fee',
        'recieving_amount',
        'approved_by'
    ];

    public $timestamps = false;

    protected $table = 'withdrawal';

    public function getClient()
    {
        return $this->hasOne(Client::class,'id','client');
    }
    public function User()
    {
        return $this->hasOne(User::class,'id','approved_by');
    }

    public function withdrawStatus()
    {
        if ($this->status==0) {
            return "Pending";
        }else if ($this->status==1) {
            return "Approved";
        }else{
            return "Not Approved";
        } 
    }

    public function currencyType()
    {
        return $this->hasOne(CurrencyType::class,'id','currency_type');
    }

    public function cyptoNetwork()
    {
        return $this->hasOne(CryptoNetwork::class,'id','cypto_network');
    }

}
