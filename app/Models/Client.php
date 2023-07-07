<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'membership_no',
        'created_at',
        'is_active',
        'email',
        'first_name',
        'last_name',
        'full_name',
        'country',
        'password',
        'sponsor',
        'sponsor_side',
        'left_child',
        'right_child',
        'parent',
        'client_title',
        'dob',
        'phone_number',
        'address',
        'identity_doc_type',
        'id_front',
        'id_back',
        'selfie',
        'client_fund_source',
        'kyc_submit_date',
        'kyc_approved_date',
        'kyc_status',
        'wallet',
        'holding_wallet',
        'left_bv_rewards',
        'right_bv_rewards',
        'left_head_count',
        'right_head_count',
        'kyc_approved_by'
    ];

    public $timestamps = false;
    
    protected $table = 'client';


    public function getSponsor()
    {
        return $this->hasOne(self::class,'id','sponsor');
    }

    public function getParent()
    {
        return $this->hasOne(self::class,'id','parent');
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class,'id','country');
    }
    
    public function getClient()
    {
        return $this->hasOne(Client::class,'id','client');
    }

    public function headStatus()
    {
        if ($this->is_active==1) {
            return "Active";
        }else{
            return "Not Active";
        } 
    }

    public function getSponsorSide()
    {
        if ($this->sponsor_side==1) {
            return "Right";
        }else{
            return "Left";
        } 
    }

    public function getSelfieImage()
    {
        return $this->hasOne(Image::class,'id','selfie');
    }

    public function getFrontImage()
    {
        return $this->hasOne(Image::class,'id','id_front');
    }

    public function getBackImage()
    {
        return $this->hasOne(Image::class,'id','id_back');
    }

    public function getClientTitle()
    {
        return $this->hasOne(ClientTitle::class,'id','client_title');
    }

    public function getClientFundSource()
    {
        return $this->hasOne(ClientFundSource::class,'id','client_fund_source');
    }

    public function userCount()
    {
        $total_users = User::count();
        return $total_users;
    }

    // $total_users = User::count();

    public function getInitialFund()
    {
        $initial_fund = Funding_payment::where('client',$this->id)->where('funding_type',1)->first();
        return $initial_fund;
    }

    public function getIdentityDocType()
    {
        return $this->hasOne(IdentityDocType::class,'id','identity_doc_type');
    }
    public function User()
    {
        return $this->hasOne(User::class,'id','kyc_approved_by');
    }

    public function getInitialFundForClintList()
    {
        //$initial_fund = hasOne(Funding_payment::class,'client','id');
        
        //Funding_payment::where('client',$this->id)->where('funding_type',1)->first();
        return $this->hasMany(Funding_payment::class,'client','id');;
    }

}
