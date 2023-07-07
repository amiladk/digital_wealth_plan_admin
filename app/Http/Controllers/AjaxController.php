<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Validator;

use App\Models\Funding_payment;
use App\Models\ReferralRewardPercentage;
use App\Models\ReferralReward;
use App\Models\FundingPaymentRewards;
use App\Models\BvReward;
use App\Models\BvRewardPercentage;
use App\Models\Client;
use App\Models\Withdrawal;
use App\Models\P2PTransfer;
use App\Models\User;
use Illuminate\Support\Facades\URL;

use Auth;
use Mail;

class AjaxController extends Controller
{
    public function approveFunding(Request $request)
    {
        try {
            $funding_payment = Funding_payment::with(['getClient'])->find($request->funding_payment);

            if ($funding_payment->status != 0) {
                $response = array('success'=>false,'message'=>'This funding is already approved/ disapproved.');
                return response()->json($response);
            }

            DB::beginTransaction();
            //calculating and inserting referral_rewards
            $this->calcReferralRewards($funding_payment);

            //calculating and inserting bv_rewards
            $this->calcBvRewards($funding_payment);

            //updating funding_payment table
            $funding_payment->status = 1;
            $funding_payment->approved_date = date("Y-m-d");
            $funding_payment->approved_by   = Auth::user()->id;
            $funding_payment->save();
            

            //updating client status
            $funding_payment->getClient->is_active = 1;
            $funding_payment->getClient->save();

            //updating wallet values
            $bv_rewarded_client_ids = BvReward::where('funding_payment',$funding_payment->id)->pluck('client')->toArray();
            $referral_rewarded_client_ids = ReferralReward::where('funding_payment',$funding_payment->id)->pluck('client')->toArray();
            $affected_client_ids = array_unique(array_merge($bv_rewarded_client_ids,$referral_rewarded_client_ids,[$funding_payment->client]), SORT_REGULAR);
            $this->updateWallets($affected_client_ids);

            DB::commit();

            $this->sendEmail('Approval Funding',$funding_payment->getClient->email,'email-funding-approval',$funding_payment);
            $response = array('success'=>true,'funding_payment'=>$funding_payment);
            return response()->json($response);

        }catch (\Throwable $e){
            DB::rollback();
            $response = array('success'=>false,'message'=>'Oops.. Something went wrong.','error'=>$e->getMessage());
            return response()->json($response);
        }
    }


    protected function sendEmail($subject,$user_mail,$blade,$data=null){

        Mail::send($blade,
        array(
            'data'     => $data,
            'base_url' => URL::to('/'),
        ), function($message) use ($user_mail,$subject)
        {
            $message->from(config('site-specific.site-mail-address'));
            $message->subject($subject);
            $message->to($user_mail);
        });

    }

    private function calcBvRewards($funding_payment){
        $parent = $funding_payment->getClient->getParent; 

        //inserting data to bv_reward table
        $bvRewards = $this->getBvRewards($parent,$funding_payment->id,$funding_payment->funding_type,$funding_payment->trading_amount,$funding_payment->client);
        BvReward::insert($bvRewards);
    }

    private function getBvRewards($client,$earned_from,$funding_type,$amount,$previous,$result=array()){
        
        //getting side of the funding
        $pre_balanced = min($client->left_bv_rewards,$client->right_bv_rewards);
        $left_bv_rewards = $client->left_bv_rewards-$pre_balanced;
        $right_bv_rewards = $client->right_bv_rewards-$pre_balanced;
        $total_left_bv = $client->left_bv_rewards;
        $total_right_bv = $client->right_bv_rewards;
        $left_bv = 0; $right_bv = 0;
        //getting earning percentage
        $earning_percentage = $this->getEarningPercentage($client->id,$funding_type);
        $bv_reward_amount = round($amount * ($earning_percentage / 100),2);
        if ($previous==$client->left_child) {
            $funding_side = 0;
            $left_bv_rewards += $bv_reward_amount;
            $total_left_bv += $bv_reward_amount;
            $left_bv = $bv_reward_amount;
        }elseif ($previous==$client->right_child) {
            $funding_side = 1;
            $right_bv_rewards += $bv_reward_amount;
            $total_right_bv += $bv_reward_amount;
            $right_bv = $bv_reward_amount;
        }else {
            return $result;
        }
        $balanced_amount = min($left_bv_rewards,$right_bv_rewards);

        $reward_data = array(
            'client'                => $client->id,
            'funding_payment'       => $earned_from,
            'funding_side'          => $funding_side,
            'funding_amount'        => $amount,
            'left_bv_rewards'       => $left_bv,
            'right_bv_rewards'      => $right_bv,
            'balanced_amount'       => $balanced_amount,
            'earning_percentage'    => $earning_percentage,
            'amount'                => $balanced_amount,
            'remaining_left_bv'     => $left_bv_rewards - $balanced_amount,
            'remaining_right_bv'    => $right_bv_rewards - $balanced_amount,
        );

        array_push($result,$reward_data);

        //updating client left/right bv rewards
        $client->left_bv_rewards = $total_left_bv;
        $client->right_bv_rewards = $total_right_bv;
        $client->save();

        //inserting data to funding_payment_rewards
        if ($reward_data['amount']>0) {
            $this->calcFundingPaymentRewards($client->id,$earned_from,2,$reward_data['amount'],'bv');   
        }

        if($client->getParent){
            $result = $this->getBvRewards($client->getParent,$earned_from,$funding_type,$amount,$client->id,$result);
        }
        return $result;
    }


    private function calcReferralRewards($funding_payment){
        $reward_stages = ReferralRewardPercentage::where('type',$funding_payment->funding_type)->orderBy('level')->get();
        $sponsor = $funding_payment->getClient->getSponsor; 
        foreach ($reward_stages as $key => $item) {
            if ($sponsor) {
                //inserting data to referral_reward table
                $reward_data = array(
                    'client'            => $sponsor->id,
                    'funding_payment'   => $funding_payment->id,
                    'amount'            => round($funding_payment->trading_amount * ($item->percentage/100),2),
                    'earning_percentage'=> $item->percentage,
                );
                $referal_reward = ReferralReward::create($reward_data);
                
                //inserting data to funding_payment_rewards
                $this->calcFundingPaymentRewards($sponsor->id,$funding_payment->id,1,$reward_data['amount']);
                $sponsor = $sponsor->getSponsor;
            }else{
                break;
            }
        }
    }


    
    private function calcFundingPaymentRewards($client,$earned_from,$reward_type,$amount,$earning_type='referral'){
        $fundings = Funding_payment::where('client',$client)
                        ->where('status',1)
                        ->where('other_rewards_completed',0)
                        ->orderBy('created_at')->get();

        $bv_eligibility= true;
        if ($earning_type=='bv') {
            $bv_eligibility = $this->isBvElegible($client);
        }

        $remaining_amount = $amount;
        
        if ($fundings && $bv_eligibility) {
            foreach ($fundings as $key => $item) {
                $available_amount = $item->other_reward_limit - $item->achieved_rewards;
                $reward_data = array(
                    'funding_payment'   => $item->id,
                    'client'            => $client,
                    'earned_from'       => $earned_from,
                    'reward_type'       => $reward_type,
                    'amount'            => $remaining_amount,
                );
                if ($remaining_amount > $available_amount) {
                    $reward_data['amount'] = $available_amount;
                    $item->other_rewards_completed = 1;
                }
                $referal_reward = FundingPaymentRewards::create($reward_data);
                //updating achieved rewards in the funding_payment
                $item->achieved_rewards = $item->achieved_rewards + $reward_data['amount'];
                $item->save();

                $remaining_amount = $remaining_amount - $reward_data['amount'];
                if ($remaining_amount <= 0) {
                    break;
                }
            }
        }

        if ($remaining_amount > 0) {
            $reward_data = array(
                'client'     => $client,
                'earned_from'=> $earned_from,
                'reward_type'=> $reward_type,
                'amount'     => $remaining_amount,
            );
            $referal_reward = FundingPaymentRewards::create($reward_data);
        }
    }

    
    private function getEarningPercentage($client,$funding_type){
        $funding = Funding_payment::where('client',$client)
                        ->where('status',1)
                        ->where('other_rewards_completed',0)
                        ->orderBy('trading_amount','desc')->first();
        if ($funding) {
            if ((int)$funding_type==1 || $funding_type=='1') {
                return $funding->bv_funding_percentage;
            }else {
                return $funding->bv_topup_percentage;
            }
        }else {
            return BvRewardPercentage::where('is_default',true)
                                    ->where('type',$funding_type)
                                    ->first()->percentage;
        }
    }


    //migration adjusment functions
    public function bvRewardsFundingPayment(Request $request){
        $funding_payment = Funding_payment::with(['getClient'])->find($request->id);
        $this->calcBvRewards($funding_payment);
    }


    public function getEmailByClient(Request $request){
        // $membership_no=$request->input_data;
        $client_email = $request->input_email;
        $id = $request->id;
        $client = Client::where('email', $client_email)->where('id', '!=' ,$id)->get();
        if (count($client)==0) {
            return response()->json(array('success'=>true,'msg' => 'susscess')); 
        }
        return response()->json(array('success'=>false, 'msg' => 'Eamil Allrady taken')); 
        
    }

        /*
    |--------------------------------------------------------------------------
    |Public function / Dashbord Counts (Rewards, Holding Balance and user  )
    |--------------------------------------------------------------------------
    */

    public function getDashbordCounts(Request $request){
        try {
           
            if(isset($request->fromDate , $request->toDate)){
                $fromDate             = $request->fromDate;
                $toDate               = $request->toDate;
                $total_users          = Client::whereBetween('created_at', [$fromDate, $toDate])->count();
                $total_initial_funds  = Funding_payment::where('status',1)->where('funding_type',1)->whereBetween('approved_date', [$request->fromDate, $request->toDate])->count();
                $total_top_ups        = Funding_payment::where('status',1)->where('funding_type',2)->whereBetween('approved_date', [$request->fromDate, $request->toDate])->count();
            }else{
                $total_users          = Client::count();
                $total_initial_funds  = Funding_payment::where('status',1)->where('funding_type',1)->count();
                $total_top_ups        = Funding_payment::where('status',1)->where('funding_type',2)->count();
                $fromDate             = null;
                $toDate               = null;
            }
          
           
            $response_array = array(
                        'success'               => true,
                        'total_users'           => $total_users,
                        'total_initial_funds'   => $total_initial_funds,
                        'total_top_ups'         => $total_top_ups,
                        'total_counts'          => $this->dashboardCounts($fromDate ,$toDate),
                       
                        
            );
            return response()->json($response_array);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    

    protected function dashboardCounts($fromDate,$toDate){
        if ($fromDate ==NULL && $toDate==NULL){
            $total_initial_funds_up_to_date                     = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1"))[0]->value;
            $total_top_up_funds_up_to_date                      = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1"))[0]->value;
            $total_withdrawals_up_to_date                       = DB::select( DB::raw("SELECT IFNULL(SUM(recieving_amount),0) AS value FROM `withdrawal` WHERE status = 1"))[0]->value;
            $total_initial_funds_service_charges_up_to_date     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1"))[0]->value;
            $total_balance_funds                                = ($total_initial_funds_up_to_date+$total_top_up_funds_up_to_date)-$total_withdrawals_up_to_date;
            $total_initial_funds_up_to_date_by_crypto           = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1 AND funding_payment_method = 1"))[0]->value;
            $total_initial_funds_up_to_date_by_wallet           = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1 AND funding_payment_method = 2"))[0]->value;
            $total_top_up_funds_up_to_date_by_crypto            = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1 AND funding_payment_method = 1"))[0]->value;
            $total_top_up_funds_up_to_date_by_wallet            = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1 AND funding_payment_method = 2"))[0]->value;
            $total_initial_funds_service_charges_up_to_date_by_crypto     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1 AND funding_payment_method = 1"))[0]->value;
            $total_initial_funds_service_charges_up_to_date_by_wallet     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1 AND funding_payment_method = 2"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date_by_crypto      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1 AND funding_payment_method = 1"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date_by_wallet      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1 AND funding_payment_method = 2"))[0]->value;
            $total_withdrawal_service_charges_up_to_date                  = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM `withdrawal` WHERE status = 1"))[0]->value;
            $total_p2p_service_charges_up_to_date                         = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM `p2p_transfer`"))[0]->value;
            $transaction_fee                                              =  $total_withdrawal_service_charges_up_to_date +  $total_p2p_service_charges_up_to_date;

          

            $total_counts = array(
                               'total_initial_funds_up_to_date'                 =>number_format($total_initial_funds_up_to_date,2),
                               'total_top_up_funds_up_to_date'                  =>number_format($total_top_up_funds_up_to_date,2),
                               'total_withdrawals_up_to_date'                   =>number_format($total_withdrawals_up_to_date,2),
                               'total_initial_funds_service_charges_up_to_date' =>number_format($total_initial_funds_service_charges_up_to_date,2),
                               'total_top_up_funds_service_charges_up_to_date'  =>number_format($total_top_up_funds_service_charges_up_to_date,2),
                               'total_balance_funds'                            =>number_format($total_balance_funds,2),
                               'total_initial_funds_up_to_date_by_crypto'       =>number_format($total_initial_funds_up_to_date_by_crypto ,2),
                               'total_initial_funds_up_to_date_by_wallet'       =>number_format($total_initial_funds_up_to_date_by_wallet ,2),
                               'total_top_up_funds_up_to_date_by_crypto'        =>number_format($total_top_up_funds_up_to_date_by_crypto ,2),
                               'total_top_up_funds_up_to_date_by_wallet'        =>number_format($total_top_up_funds_up_to_date_by_wallet ,2),
                               'total_initial_funds_service_charges_up_to_date_by_crypto'    => number_format($total_initial_funds_service_charges_up_to_date_by_crypto ,2),
                               'total_initial_funds_service_charges_up_to_date_by_wallet'    => number_format($total_initial_funds_service_charges_up_to_date_by_wallet ,2),
                               'total_top_up_funds_service_charges_up_to_date_by_crypto'     => number_format($total_top_up_funds_service_charges_up_to_date_by_crypto ,2),
                               'total_top_up_funds_service_charges_up_to_date_by_wallet'     => number_format($total_top_up_funds_service_charges_up_to_date_by_wallet ,2),
                               'total_withdrawal_service_charges_up_to_date'                 =>number_format($total_withdrawal_service_charges_up_to_date,2),
                               'total_p2p_service_charges_up_to_date'                        =>number_format($total_p2p_service_charges_up_to_date,2),
                                'transaction_fee'                                            =>number_format($transaction_fee,2),
                            );
    
            return $total_counts;

        }else{
            
            $total_initial_funds_up_to_date                     = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1 And approved_date between '$fromDate' AND '$toDate' ") )[0]->value;
            $total_top_up_funds_up_to_date                      = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_withdrawals_up_to_date                       = DB::select( DB::raw("SELECT IFNULL(SUM(recieving_amount),0) AS value FROM `withdrawal` WHERE status = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_initial_funds_service_charges_up_to_date     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_balance_funds                                = ($total_initial_funds_up_to_date+$total_top_up_funds_up_to_date)-$total_withdrawals_up_to_date;
            $total_initial_funds_up_to_date_by_crypto           = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1 AND funding_payment_method = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_initial_funds_up_to_date_by_wallet           = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1 AND funding_payment_method = 2 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_top_up_funds_up_to_date_by_crypto            = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1 AND funding_payment_method = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_top_up_funds_up_to_date_by_wallet            = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1 AND funding_payment_method = 2 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_initial_funds_service_charges_up_to_date_by_crypto     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1 AND funding_payment_method = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_initial_funds_service_charges_up_to_date_by_wallet     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1 AND funding_payment_method = 2 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date_by_crypto      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1 AND funding_payment_method = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date_by_wallet      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1 AND funding_payment_method = 2 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;       
            $total_withdrawal_service_charges_up_to_date                  = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM `withdrawal` WHERE status = 1 And approved_date between '$fromDate' AND '$toDate'"))[0]->value;
            $total_p2p_service_charges_up_to_date                         = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM `p2p_transfer` WHERE created_at between '$fromDate' AND '$toDate'"))[0]->value;
            $transaction_fee                                              =  $total_withdrawal_service_charges_up_to_date +  $total_p2p_service_charges_up_to_date;


            
            $total_counts = array(
                            'total_initial_funds_up_to_date'                    =>number_format($total_initial_funds_up_to_date,2),
                            'total_top_up_funds_up_to_date'                     =>number_format($total_top_up_funds_up_to_date,2),
                            'total_withdrawals_up_to_date'                      =>number_format($total_withdrawals_up_to_date,2),
                            'total_initial_funds_service_charges_up_to_date'    =>number_format($total_initial_funds_service_charges_up_to_date,2),
                            'total_top_up_funds_service_charges_up_to_date'     =>number_format($total_top_up_funds_service_charges_up_to_date,2),
                            'total_balance_funds'                               =>number_format($total_balance_funds,2),
                            'total_initial_funds_up_to_date_by_crypto'          =>number_format($total_initial_funds_up_to_date_by_crypto ,2),
                            'total_initial_funds_up_to_date_by_wallet'          =>number_format($total_initial_funds_up_to_date_by_wallet ,2),
                            'total_top_up_funds_up_to_date_by_crypto'           =>number_format($total_top_up_funds_up_to_date_by_crypto ,2),
                            'total_top_up_funds_up_to_date_by_wallet'           =>number_format($total_top_up_funds_up_to_date_by_wallet ,2),
                            'total_initial_funds_service_charges_up_to_date_by_crypto'    => number_format($total_initial_funds_service_charges_up_to_date_by_crypto ,2),
                            'total_initial_funds_service_charges_up_to_date_by_wallet'    => number_format($total_initial_funds_service_charges_up_to_date_by_wallet ,2),
                            'total_top_up_funds_service_charges_up_to_date_by_crypto'     => number_format($total_top_up_funds_service_charges_up_to_date_by_crypto ,2),
                            'total_top_up_funds_service_charges_up_to_date_by_wallet'     => number_format($total_top_up_funds_service_charges_up_to_date_by_wallet ,2),

                            'total_withdrawal_service_charges_up_to_date'                 =>number_format($total_withdrawal_service_charges_up_to_date,2),
                            'total_p2p_service_charges_up_to_date'                        =>number_format($total_p2p_service_charges_up_to_date,2),
                            'transaction_fee'                                             =>number_format($transaction_fee,2),
                        
                            );

            return $total_counts;

        }
    
        
   }


/*
|--------------------------------------------------------------------------
|public get pending Perchasess
|--------------------------------------------------------------------------
*/

public function pendingPerchasess(Request $request){

    $pending_perchasess = Funding_payment::with('getImage','getClient','getFundingPaymentMethod','User');
    //filtering
    $search_value       = $request->search['value'];
    $approved           = $request->columns[8]['search']['value'];
    $disapproved        = $request->columns[8]['search']['value'];
    $pending            = $request->columns[8]['search']['value'];

    if($request->search['value']!=null){
        $pending_perchasess =  $pending_perchasess->WhereHas('getClient', function($query) use($search_value){
                                            $query->where('membership_no', 'like', '%' . $search_value . '%'); 
                                            })->orWhereHas('getClient', function($query) use($search_value){
                                                $query->where('first_name','like', '%' . $search_value . '%'); 
                                            });
    }

    if($approved!=null){
        $pending_perchasess =  $pending_perchasess->where('status',  $approved );             
    }
    if($disapproved!=null){
        $pending_perchasess =  $pending_perchasess->where('status',  $disapproved );               
    }
    if($pending!=null){
        $pending_perchasess =  $pending_perchasess->where('status',  $pending);              
    }
   
   
     //pagination
     $page = ($request->start/$request->length)+1;
     $request->merge(['page' => $page]);
     if($request->length != -1){
         $pending_perchasess = $pending_perchasess->paginate($request->length);
     }
     else{
         $pending_perchasess = $pending_perchasess->paginate($pending_perchasess->count());
     }


    foreach($pending_perchasess as $key => $data){
        $pending_perchasess[$key]->approvedBy   = '';
        $pending_perchasess[$key]->action       = '';
        if($data->approved_by != null){
            $pending_perchasess[$key]->approvedBy = $data->User->name;
        }
        if($data->status == 0){
            $pending_perchasess[$key]->action = '<button type="button" data-parent=\''.json_encode($data).'\' class="btn btn-info waves-effect waves-light btn-sm actionBtn_'.$data->id.'"  onclick="showPurchaseModal(this)">View</button>
                                                 <button type="button" class="btn btn-success btn-sm actionBtn_'.$data->id.'" onclick="approveFundingPurchase('.$data->id.')">Approve</button>
                                                 <button type="button" class="btn btn-danger btn-sm actionBtn_'.$data->id.'" onclick="disapprovePurchase('.$data->id.')">Disapprove</button>';
        }else {
            $pending_perchasess[$key]->action = '<button type="button" data-parent=\''.json_encode($data).'\' class="btn btn-info waves-effect waves-light btn-sm actionBtn_'.$data->id.'"  onclick="showPurchaseModal(this)">View</button>';
        }
    }
    
    $paginated_list = json_decode(json_encode($pending_perchasess));
    $pending_perchasess = $pending_perchasess->map(function ($pending_perchasess) {

    return $pending_perchasess;
    })->all();
    
    $response['draw']=$request->draw;
    $response['recordsFiltered'] = $paginated_list->total;
    $response['recordsTotal'] = $paginated_list->total;
    $response['data'] = $pending_perchasess;
    
    return response()->json($response);
}

/*
|--------------------------------------------------------------------------
|public get pending kycs
|--------------------------------------------------------------------------
*/


public function pendingKyc(Request $request){

    $pending_kyc =  Client::with('getSponsor','getCountry','getSelfieImage','getFrontImage','getBackImage','User');
    //filtering
    $search_value       = $request->search['value'];
    $approved           = $request->columns[3]['search']['value'];
    $disapproved        = $request->columns[3]['search']['value'];
    $pending            = $request->columns[3]['search']['value'];

    if($request->search['value']!=null){
        $pending_kyc =  $pending_kyc->Where('membership_no', 'like', '%' . $search_value . '%')
                                    ->orWhere('first_name', 'like', '%' . $search_value . '%');
                                                   
    }

    if($approved!=null){
        $pending_kyc =  $pending_kyc->where('kyc_status',  $approved );             
    }
    if($disapproved!=null){
        $pending_kyc =  $pending_kyc->where('kyc_status',  $disapproved );               
    }
    if($pending!=null){
        $pending_kyc =  $pending_kyc->where('kyc_status',  $pending);              
    }
   

    //pagination
    $page = ($request->start/$request->length)+1;
    $request->merge(['page' => $page]);
    if($request->length != -1){
        $pending_kyc = $pending_kyc->paginate($request->length);
    }
    else{
        $pending_kyc = $pending_kyc->paginate($pending_kyc->count());
    }

    foreach($pending_kyc as $key => $data){
        $pending_kyc[$key]->approvedBy   = '';
        $pending_kyc[$key]->action       = '';
        if($data->kyc_approved_by != null){
            $pending_kyc[$key]->approvedBy = $data->User->name;
        }
        if($data->kyc_status == 0){
            $pending_kyc[$key]->action = '<button type="button" data-parent=\''.json_encode($data).'\' class="btn btn-info waves-effect waves-light btn-sm actionBtn_'.$data->id.'"  onclick="showKycModal(this)">View</button>
                                                 <button type="button" class="btn btn-success btn-sm actionBtn_'.$data->id.'" onclick="approveKyc('.$data->id.')">Approve</button>
                                                 <button type="button" class="btn btn-danger btn-sm actionBtn_'.$data->id.'" onclick="disapproveKyc('.$data->id.')">Disapprove</button>';
        }else{
            $pending_kyc[$key]->action = '<button type="button" data-parent=\''.json_encode($data).'\' class="btn btn-info waves-effect waves-light btn-sm actionBtn_'.$data->id.'"  onclick="showKycModal(this)">View</button>';
        }
    }
    
    $paginated_list = json_decode(json_encode($pending_kyc));
    $pending_kyc = $pending_kyc->map(function ($pending_kyc) {

    return $pending_kyc;
    })->all();
    
    $response['draw']=$request->draw;
    $response['recordsFiltered'] = $paginated_list->total;
    $response['recordsTotal'] = $paginated_list->total;
    $response['data'] = $pending_kyc;
    
    return response()->json($response);
}


/*
|--------------------------------------------------------------------------
|public get pending kycs
|--------------------------------------------------------------------------
*/


public function pendingWithdrawls(Request $request){

    $pending_withdrawls =  Withdrawal::with('getClient','currencyType','cyptoNetwork','User');
    // //filtering
    $search_value     = $request->search['value'];
    $approved         = $request->columns[9]['search']['value'];
    $disapproved      = $request->columns[3]['search']['value'];
    $pending          = $request->columns[3]['search']['value'];

    if($request->search['value']!=null){
        $pending_withdrawls =  $pending_withdrawls->WhereHas('getClient', function($query) use($search_value){
                                            $query->where('membership_no', 'like', '%' . $search_value . '%'); 
                                            })->orWhereHas('getClient', function($query) use($search_value){
                                                $query->where('first_name','like', '%' . $search_value . '%'); 
                                            });
    }

    if($approved!=null){
        $pending_withdrawls =  $pending_withdrawls->where('status', $approved );             
    }
    if($disapproved!=null){
        $pending_withdrawls =  $pending_withdrawls->where('kyc_status',  $disapproved );               
    }
    if($pending!=null){
        $pending_withdrawls =  $pending_withdrawls->where('kyc_status',  $pending);              
    }
   
    // //pagination
    // $page = ($request->start/$request->length)+1;
    // $request->merge(['page' => $page]);
    // $pending_withdrawls = $pending_withdrawls->paginate($request->length);

     //pagination
     $page = ($request->start/$request->length)+1;
     $request->merge(['page' => $page]);
     if($request->length != -1){
         $pending_withdrawls = $pending_withdrawls->paginate($request->length);
     }
     else{
         $pending_withdrawls = $pending_withdrawls->paginate($pending_withdrawls->count());
     }


    foreach($pending_withdrawls as $key => $data){
        $pending_withdrawls[$key]->approvedBy    = ' ';
        $pending_withdrawls[$key]->action        = ' ';
        $pending_withdrawls[$key]->currencyTypeWith  = ' ';
        $pending_withdrawls[$key]->cyptoNetworkWith  = ' ';
        if($data->approved_by != null){
            $pending_withdrawls[$key]->approvedBy = $data->User->name;
        }

        if($data->currencyType !== null){
            $pending_withdrawls[$key]->currencyTypeWith = $data->currencyType->title;
        }

        if($data->CyptoNetwork !== null){
            $pending_withdrawls[$key]->cyptoNetworkWith = $data->CyptoNetwork->title;
        }

        if($data->status == 0){
            $pending_withdrawls[$key]->action = '<button type="button" class="btn btn-success btn-sm actionBtn_'.$data->id.'" onclick="approvewithdraw('.$data->id.')">Approve</button>
                                                 <button type="button" class="btn btn-danger btn-sm actionBtn_'.$data->id.'" onclick="disapproveWithdraw('.$data->id.')">Disapprove</button>';
        }
    }
    
    $paginated_list = json_decode(json_encode($pending_withdrawls));
    $pending_withdrawls = $pending_withdrawls->map(function ($pending_withdrawls) {

    return $pending_withdrawls;
    })->all();
    
    $response['draw']=$request->draw;
    $response['recordsFiltered'] = $paginated_list->total;
    $response['recordsTotal'] = $paginated_list->total;
    $response['data'] = $pending_withdrawls;
    
    return response()->json($response);
}


/*
|--------------------------------------------------------------------------
|public get p2p Trasfer
|--------------------------------------------------------------------------
*/


public function p2pTrasfer(Request $request){

    $p2p_trasfer =  P2PTransfer::with('getFrom:id,membership_no,first_name','getTo:id,membership_no,first_name');
    // //filtering
    $search_value     = $request->search['value'];

    if($request->search['value']!=null){
        $p2p_trasfer =  $p2p_trasfer->WhereHas('getFrom', function($query) use($search_value){
                                            $query->where('membership_no', 'like', '%' . $search_value . '%'); 
                                            })->orWhereHas('getFrom', function($query) use($search_value){
                                                $query->where('first_name','like', '%' . $search_value . '%'); 
                                            })->orWhereHas('getTo', function($query) use($search_value){
                                                $query->where('membership_no','like', '%' . $search_value . '%'); 
                                            })->orWhereHas('getTo', function($query) use($search_value){
                                                $query->where('first_name','like', '%' . $search_value . '%'); 
                                            });
    }
   
    //pagination
    $page = ($request->start/$request->length)+1;
    $request->merge(['page' => $page]);
    if($request->length != -1){
        $p2p_trasfer = $p2p_trasfer->paginate($request->length);
    }
    else{
        $p2p_trasfer = $p2p_trasfer->paginate($p2p_trasfer->count());
    }
    


    
    $paginated_list = json_decode(json_encode($p2p_trasfer));
    $p2p_trasfer = $p2p_trasfer->map(function ($p2p_trasfer) {

    return $p2p_trasfer;
    })->all();
    
    $response['draw']=$request->draw;
    $response['recordsFiltered'] = $paginated_list->total;
    $response['recordsTotal'] = $paginated_list->total;
    $response['data'] = $p2p_trasfer;
    
    return response()->json($response);
}



/*
|--------------------------------------------------------------------------
|public get client List
|--------------------------------------------------------------------------
*/


public function clientList(Request $request){
   
    $client_list = DB::table('client');
     // //filtering
    $search_value     = $request->search['value'];

    if($request->search['value']!=null){
        $client_list =  $client_list->where('membership_no', 'like', '%' . $search_value . '%')
                                    ->orwhere('full_name', 'like', '%' . $search_value . '%') ;
                                            
    }
 
    
     //pagination
     $page = ($request->start/$request->length)+1;
     $request->merge(['page' => $page]);
     if($request->length != -1){
         $client_list = $client_list->paginate($request->length);
     }
     else{
         $client_list = $client_list->paginate($client_list->count());
     }

    foreach($client_list as $key => $data){
        $client_list[$key]->initialfund    = '';
        $client_list[$key]->action   = '';

        if($data->id != null){
            $client_list[$key]->initialfund = $this->getInitialFund($data->id);
        }
        $client_list[$key]->action       = '<a  target="_blank" href="/edit-client/'.$data->id.'" class="btn btn-info waves-effect waves-light btn-sm">Edit</a>
                                            <a  target="_blank" href="/client-summary/'.$data->id.'" class="btn btn-info waves-effect waves-light btn-sm">View Summary</a>'; 
    }
    
    $paginated_list = json_decode(json_encode($client_list));
    $client_list = $client_list->map(function ($client_list) {

    return $client_list;
    })->all();
    
    $response['draw']=$request->draw;
    $response['recordsFiltered'] = $paginated_list->total;
    $response['recordsTotal'] = $paginated_list->total;
    $response['data'] = $client_list;
    
    return response()->json($response);
}

    public function getInitialFund($id)
    {
        $initial_fund = Funding_payment::where('client',$id)->where('funding_type',1)->first();
        if ( $initial_fund != null) {
            return $initial_fund->trading_amount;
        }
        
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Liability Report Data
    |--------------------------------------------------------------------------
    */
    public function getLiabilityReportData(Request $request){

        //$client_list = DB::table('funding_payment');
        $liability_data =  Funding_payment::with('getClient:id,membership_no,first_name,wallet,holding_wallet')->where('status',1);
         // //filtering
        $search_value     = $request->search['value'];
        $totalInvestment                = $liability_data->sum('trading_amount');
        $totalPaybale                   = $liability_data->sum('daily_reward_limit');
        $totalDailyDueAmount            = $liability_data->sum('daily_reward_amount');
        $totalAccumalatedUpToDate       = $this->getAccumalateduUpToDate(null);
        
    
        if($request->search['value']!=null){
            $liability_data =  $liability_data->WhereHas('getClient', function($query) use($search_value){
                                                $query->where('membership_no', 'like', '%' . $search_value . '%'); 
                                                })->orWhereHas('getClient', function($query) use($search_value){
                                                    $query->where('first_name','like', '%' . $search_value . '%'); 
                                                });  
        }
       
         //pagination
         $page = ($request->start/$request->length)+1;
         $request->merge(['page' => $page]);
         if($request->length != -1){
             $liability_data = $liability_data->paginate($request->length);
         }
         else{
             $liability_data = $liability_data->paginate($liability_data->count());
         }
         //$totalInvestment1 = 0;
        foreach($liability_data as $key => $data){

            $liability_data[$key]->earning_eligibility         = $data->other_reward_limit / $data->trading_amount;
            $liability_data[$key]->accumalated_up_todate       = '';
            $liability_data[$key]->Paid_more_than              = $data->achieved_rewards - $data->daily_reward_limit;
            $liability_data[$key]->balance_to_be_accumalated   = $data->daily_reward_limit - $data->achieved_rewards;
            $liability_data[$key]->date_range_due_report       = Carbon::now()->format('y-m-d');
            //$totalInvestment1 += $data->trading_amount;
        
            if($data->id != null){
                $liability_data[$key]->accumalated_up_todate = $this->getAccumalateduUpToDate($data->id);
            }
            
        }
        
        // $totalInvestment                = $liability_data->sum('trading_amount');
        $paginated_list = json_decode(json_encode($liability_data));
        $liability_data = $liability_data->map(function ($liability_data) {
    
        return $liability_data;
        })->all();
        
        $response['draw']                   = $request->draw;
        $response['recordsFiltered']        = $paginated_list->total;
        $response['recordsTotal']           = $paginated_list->total;
        $response['data']                   = $liability_data;
        $response['investamnt_total']       = $totalInvestment;
        $response['total_paybale']          = $totalPaybale;
        $response['total_daily_due_amount'] = $totalDailyDueAmount;
        $response['total_accumalated_up_to_date']    = $totalAccumalatedUpToDate;
        $response['total_balance_to_be_accumalated'] = DB::select( DB::raw("SELECT IFNULL(SUM(IF(daily_reward_limit - achieved_rewards > 0,daily_reward_limit - achieved_rewards,0)),0) AS value FROM `funding_payment`  WHERE status = 1"))[0]->value;
        $response['total_paid_more_than']            = DB::select( DB::raw("SELECT IFNULL(SUM(IF(achieved_rewards - daily_reward_limit > 0,achieved_rewards - daily_reward_limit,0)),0) AS value FROM `funding_payment` WHERE status = 1"))[0]->value;
        return response()->json($response);
    }
    
    public function getAccumalateduUpToDate($id)
    {
        if ($id!=null) {
            $accumalated_up_todate = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward` WHERE funding_payment = $id"))[0]->value;
            return $accumalated_up_todate;
        }else {
            $accumalated_up_todate = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward`"))[0]->value;
            return $accumalated_up_todate;
        }
        
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Liability Report Data Client Wise
    |--------------------------------------------------------------------------
    */
    public function getLiabilityReportDataClientWise(Request $request){
    
        $liability_data =   DB::table('client')
                                        ->select('client.id as id', 
                                                'client.membership_no', 
                                                'client.first_name', 
                                                'client.wallet',
                                                'client.holding_wallet',
                                                'client.created_at',
                                                DB::raw('sum(funding_payment.trading_amount) as trading_amount'),
                                                DB::raw('sum(funding_payment.daily_reward_limit) as daily_reward_limit'),
                                                DB::raw('sum(funding_payment.daily_reward_amount) as daily_reward_amount'),
                                                DB::raw('sum(funding_payment.achieved_rewards) as achieved_rewards'),     
                                                )     
                                        ->leftjoin('funding_payment', 'client.id', '=', 'funding_payment.client')
                                        ->where('funding_payment.status',1)
                                        ->orderBy('client.id', 'asc')
                                        ->groupBy('client.id','client.membership_no','client.first_name','client.wallet','client.holding_wallet','client.created_at')
                                        ;
        //filtering
        
        $search_value     = $request->search['value'];

        if($request->search['value']!=null){
            $liability_data =  $liability_data->where('client.membership_no', 'like', '%' . $search_value . '%')
                                                ->orWhere('client.first_name','like', '%' . $search_value . '%'); 
                                                
       
        }

        //pagination
        $page = ($request->start/$request->length)+1;
        $request->merge(['page' => $page]);
        if($request->length != -1){
            $liability_data = $liability_data->paginate($request->length);
        }
        else{
            $liability_data = $liability_data->paginate($liability_data->get()->count());
            
        }
        //$totalInvestment1 = 0;
        foreach($liability_data as $key => $data){
             $liability_data[$key]->referral_reward             = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward` WHERE `client` = $data->id"))[0]->value;
             $liability_data[$key]->bv_reward                   = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward` WHERE `client` = $data->id"))[0]->value;
             $liability_data[$key]->balance_to_be_accumalated   = $data->daily_reward_limit - $data->achieved_rewards;
             $liability_data[$key]->Paid_more_than              = $data->achieved_rewards - $data->daily_reward_limit;
             $liability_data[$key]->date_range_due_report       = Carbon::now()->format('Y-m-d');
             $liability_data[$key]->registered_date             = Carbon::parse($data->created_at)->format('Y-m-d');
            if($data->id != null){
                $liability_data[$key]->accumalated_up_todate = $this->getAccumalateduUpToDateClientWise($data->id);
            }
            
        }
       
        $paginated_list = json_decode(json_encode($liability_data));
        $liability_data = $liability_data->map(function ($liability_data) {

        return $liability_data;
        })->all();
        
        $response['draw']                   = $request->draw;
        $response['recordsFiltered']        = $paginated_list->total;
        $response['recordsTotal']           = $paginated_list->total;
        $response['data']                   = $liability_data;
        $response['total_data']             = $this->getTotalForClientWiseLiablityReport();
        $response['total_accumalated_up_to_date']    = $this->getAccumalateduUpToDateClientWise(null);;
        $response['total_referral_reward']           = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward`"))[0]->value;
        $response['total_bv_reward']                 = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward`"))[0]->value;
        $response['total_balance_to_be_accumalated'] = DB::select( DB::raw("SELECT IFNULL(SUM(daily_reward_limit - achieved_rewards),0) AS value FROM `funding_payment` WHERE status = 1"))[0]->value;
        $response['total_paid_more_than']            = DB::select( DB::raw("SELECT IFNULL(SUM(achieved_rewards - daily_reward_limit),0) AS value FROM `funding_payment` WHERE status = 1"))[0]->value;
        $response['total_available_balance']         = DB::select( DB::raw("SELECT IFNULL(SUM(wallet),0) AS value FROM `client`"))[0]->value;;
        $response['total_holding_wallet']         = DB::select( DB::raw("SELECT IFNULL(SUM(holding_wallet),0) AS value FROM `client`"))[0]->value;
       
        return response()->json($response);
    }

    public function getAccumalateduUpToDateClientWise($id)
    {   
        if ($id!=null) {
            $accumalated_up_todate = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward`  WHERE `client` = $id"))[0]->value;
            return $accumalated_up_todate;
        }else {
            $accumalated_up_todate = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward`"))[0]->value;
            return $accumalated_up_todate;
        }
        
    }

    

    /*
    |--------------------------------------------------------------------------
    |Public function / Total For Client Wise Liablity Report
    |--------------------------------------------------------------------------
    */

    public function getTotalForClientWiseLiablityReport()
    {   
            
        $total =   DB::table('funding_payment')
                            ->select(
                                DB::raw('sum(trading_amount) as total_trading_amount'),
                                DB::raw('sum(daily_reward_limit) as total_payble'),
                                DB::raw('sum(funding_payment.daily_reward_amount) as total_daily_due_amount'),
                                )
                            ->where('funding_payment.status',1)    
                            ->first();
        
        
        
        
        return $total;    
        
    }


    /*
    |--------------------------------------------------------------------------
    |Public function / Update KYC Terms And Condition, forth form of the wizard
    |--------------------------------------------------------------------------
    */
    public function uploadKycCropImages(Request $request){
        try {

            $validation_array = [
                'index'             => 'required',
                "image"             => 'required',
                "image_name"        => 'required',
                "identity_doc_type" => 'required',
                "id"                => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
               // return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
               return array('success'=>false, 'data'=>null, 'msg'=>implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            $response = Http::post(config('site-specific.api_url_client').'api/upload-client-kyc-images',['image'=>$validator->valid()['image'], 'file_name'=> $validator->valid()['image_name']]);
           $response_data = json_decode($response);

            if(isset($response_data->success) && $response_data->success == true){
                //$image = $this->uploadImage64Base($validator->valid()['image'],$validator->valid()['image_name'],'local-images');
                $image = $response_data->data;
                $user = Client::find($validator->valid()['id']);
                $user->identity_doc_type = $validator->valid()['identity_doc_type'];
                if($validator->valid()['index'] == 1 || $validator->valid()['index'] == 3 || $validator->valid()['index'] == 5){
                    $user->id_front = $image;
                }
                if($validator->valid()['index'] == 2 || $validator->valid()['index'] == 4){
                    $user->id_back  = $image;
                }
                if($validator->valid()['index'] == 6){
                    $user->selfie  = $image;
                }
            // $user->selfie   = $image;
                $user->save();
                DB::commit();
                return array('success'=>true, 'data'=> null, 'msg'=>'Record updated successfully!');
            }
        }
        catch (\Throwable $e){
            DB::rollback();
            return array('success'=>false, 'data'=> null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }
    }

   


}











