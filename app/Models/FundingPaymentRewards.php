<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingPaymentRewards extends Model
{
    use HasFactory;

    protected $fillable = [
        'client',
        'funding_payment',
        'earned_from',
        'reward_type',
        'amount',
    ];

    public $timestamps = false;

    protected $table = 'funding_payment_rewards';
}
