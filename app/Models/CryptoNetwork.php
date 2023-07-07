<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoNetwork extends Model
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
        'network_fee',
        'withdrawal_fee',
        'is_active',
        'client_wallet',
        'company_wallet_address',
    ];

    public $timestamps = false;

    protected $table = 'crypto_network';

}
