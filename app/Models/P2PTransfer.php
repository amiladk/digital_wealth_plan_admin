<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P2PTransfer extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'created_at',
        'from',
        'to',
        'transfer_amount',
        'transaction_fee',
        'received_amount',
    ];

    public $timestamps = false;

    protected $table = 'p2p_transfer';

        
    public function getFrom()
    {
        return $this->hasOne(Client::class,'id','from');
    }

        
    public function getTo()
    {
        return $this->hasOne(Client::class,'id','to');
    }

}
