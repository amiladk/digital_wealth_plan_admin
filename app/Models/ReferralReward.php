<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client',
        'funding_payment',
        'amount',
        'earning_percentage',
    ];

    public $timestamps = false;

    protected $table = 'referral_reward';
}
