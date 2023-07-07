<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BvRewardPercentage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'greater_than',
        'less_than',
        'percentage',
        'is_default',
    ];

    public $timestamps = false;

    protected $table = 'bv_reward_percentage';
}
