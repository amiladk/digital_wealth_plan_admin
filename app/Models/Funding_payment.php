<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Funding_payment extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'client',
        'status',
        'approved_date',
        'funding_type',
        'funding_payment_method',
        'funding_amount',
        'service_charge',
        'network_fee',
        'trading_amount',
        'daily_reward_limit',
        'other_reward_limit',
        'daily_reward_amount',
        'achieved_rewards',
        'bv_funding_percentage',
        'bv_topup_percentage',
        'currency_type',
        'network',
        'wallet_address',
        'daily_rewards_completed',
        'other_rewards_completed',
        'approved_by'
    ];

   public $timestamps = false;

    protected $table = 'funding_payment';


    public function getClient()
    {
        return $this->hasOne(Client::class,'id','client');
    }

    public function fundingTypeName()
    {
        if ($this->funding_type==1) {
            return "Funding";
        }else{
            return "Top-Up";
        } 
    }

    public function getDaysCount()
    {
        $toDate = Carbon::parse($this->approved_date);
        $fromDate = Carbon::parse(date("Y-m-d"));
  
        return $toDate->diffInDays($fromDate);  
    }

    public function getImage()
    {
        return $this->hasOne(Image::class,'id','payment_proof');
    }

    public function getFundingPaymentMethod()
    {
        return $this->hasOne(FundingPaymentMethod::class,'id','funding_payment_method');
    }

     public function User()
    {
        return $this->hasOne(User::class,'id','approved_by');
    }

}
