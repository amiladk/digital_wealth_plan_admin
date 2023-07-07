<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BvReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client',
        'funding_payment',
        'funding_side',
        'funding_amount',
        'left_bv_rewards',
        'right_bv_rewards',
        'balanced_amount',
        'earning_percentage',
        'amount',
        'remaining_left_bv',
        'remaining_right_bv',
    ];

    public $timestamps = false;

    protected $table = 'bv_reward';
}
