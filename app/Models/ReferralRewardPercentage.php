<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralRewardPercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'level',
        'percentage',
    ];

    public $timestamps = false;

    protected $table = 'referral_reward_percentage';
}
