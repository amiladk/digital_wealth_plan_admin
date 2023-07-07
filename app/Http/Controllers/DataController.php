<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CryptoNetwork;
use App\Models\CurrencyType;
use App\Models\ClientWallet;
use App\Models\User;
use App\Models\PersonalDetails;
use App\Models\Source;
use App\Models\IdentityDocType;
use App\Models\ClientTitle;
use App\Models\Funding_payment;
use App\Models\Withdrawal;
use App\Models\Client;
use App\Models\UserRole;
use App\Models\UserPermissions;
use App\Models\P2PTransfer;
use App\Models\ClientTeamMap;


use DB;
use Auth;

class DataController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    |protected function get undingPayment
    |--------------------------------------------------------------------------
    */ 
    protected function getMyFundingPayment($clintId){
        $data = Funding_payment::with('getFundingPaymentMethod')->orderBy('created_at', 'ASC')
       ->where('client',$clintId)
       ->get();
       return $data;

   }

   
   /*
   |--------------------------------------------------------------------------
   |protected function get Withdrawal
   |--------------------------------------------------------------------------
   */ 
   protected function getWithdrawal($clintId){
       $data = Withdrawal::orderBy('created_at', 'ASC')
      ->where('client',$clintId)
      ->get();
      return $data;
  }

   /*
   |--------------------------------------------------------------------------
   |protected function get Uni-Level Rewards
   |--------------------------------------------------------------------------
   */ 
   protected function getUniLevelRewards($clintId,$fundingType){
       $data = DB::table('referral_reward')
                   ->join('funding_payment', 'referral_reward.funding_payment', '=', 'funding_payment.id')
                   ->join('client', 'client.id', '=', 'funding_payment.client')
                   ->select('referral_reward.client','referral_reward.amount','referral_reward.earning_percentage','funding_payment.client', 'funding_payment.approved_date', 'funding_payment.trading_amount','client.membership_no')
                   ->where('referral_reward.client',$clintId)
                   ->where('funding_payment.funding_type',$fundingType)
                   ->get();

        

       return $data;
  }

  /*
   |--------------------------------------------------------------------------
   |protected function get  Rewards
   |--------------------------------------------------------------------------
   */
  protected function getBvRewards($clintId){
   $data = DB::table('bv_reward')
               ->join('funding_payment', 'bv_reward.funding_payment', '=', 'funding_payment.id')
               ->join('client', 'client.id', '=', 'funding_payment.client')
               ->select('funding_payment.approved_date',
                       'client.membership_no',
                       'funding_payment.trading_amount',
                       'bv_reward.earning_percentage',
                       'bv_reward.left_bv_rewards',
                       'bv_reward.right_bv_rewards', 
                       'bv_reward.balanced_amount', 
                       'bv_reward.amount',
                       'bv_reward.funding_side',
                       'funding_payment.funding_type')
               ->where('bv_reward.client',$clintId)
               ->get();
   return $data;
   }

   /*
   |--------------------------------------------------------------------------
   |protected function get Daily Rewards
   |--------------------------------------------------------------------------
   */

   protected function getDailyRewards($clintId){
       $data = DB::table('daily_reward')
                   ->join('funding_payment', 'daily_reward.funding_payment', '=', 'funding_payment.id')
                   ->select('funding_payment.trading_amount',
                           'daily_reward.created_at',
                           'daily_reward.amount','daily_reward.reward_date')
                   ->where('daily_reward.client',$clintId)
                   ->get();
       return $data;
  }

        /*
        |--------------------------------------------------------------------------
        |protected function get Bv Elegibility
        |--------------------------------------------------------------------------
        */

        protected function getBvElegibility($clintId){
           

            $left_sponsor  = Client::where('sponsor', $clintId)->where('is_active', 1)->where('sponsor_side', 0)->first();
            $right_sponsor = Client::where('sponsor', $clintId)->where('is_active', 1)->where('sponsor_side', 1)->first();
             
            if($left_sponsor && $right_sponsor){
                return "Eligible";
            }
            return "Not Eligible";
        }

                
        /*
        |--------------------------------------------------------------------------
        |protected function get Total Bv Side
        |--------------------------------------------------------------------------
        */

        protected function getTotalBvSide($clintId,$side){
            if ($side==0) {
                $total_bv_side = DB::select( DB::raw("SELECT IFNULL(SUM(left_bv_rewards),0) AS value FROM `bv_reward` WHERE client=  :client AND funding_side = :side"), 
                                    array(
                                        'client' => $clintId,
                                        'side'  => $side,
                                    ));
            }
            if ($side==1) {
                $total_bv_side = DB::select( DB::raw("SELECT IFNULL(SUM(right_bv_rewards),0) AS value FROM `bv_reward` WHERE client=  :client AND funding_side = :side"), 
                                    array(
                                        'client' => $clintId,
                                        'side'  => $side,
                                    ));
            }
                
            return $total_bv_side;
        }

        /*
        |--------------------------------------------------------------------------
        |protected function get Total Bv Side
        |--------------------------------------------------------------------------
        */
        
        
        protected function rewardsCounts($clintId){

             $referral_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward`
                 WHERE client=  :client"), 
                         array(
                             'client' => $clintId,
                         ));
             $bv_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward` 
                 WHERE client = :client"), 
                         array(
                             'client' => $clintId,
                         ));
             $daily_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward` 
                 WHERE client = :client"), 
                         array(
                             'client' => $clintId,
                         ));
             $total_earnings =  $referral_rewards[0]->value + $bv_rewards[0]->value + $daily_rewards[0]->value ;
             $response_array = array(
                                'referral_rewards'=>number_format($referral_rewards[0]->value,2),
                                'bv_rewards'=>  number_format($bv_rewards[0]->value,2),
                                'daily_rewards' => number_format($daily_rewards[0]->value,2),
                                'total_earnings' => number_format($total_earnings,2),
                             );
            //  return response()->json($response_array);
             return $response_array;
 
        }

        /*
        |--------------------------------------------------------------------------
        |protected function get Total Withdrawals
        |--------------------------------------------------------------------------
        */

        protected function getTotalWithdrawals($clintId){
            $total_withdrawals = DB::select( DB::raw("SELECT IFNULL(SUM(withdraw_amount),0) AS value FROM withdrawal WHERE client=  :client AND status = :status"), 
                                     array(
                                         'client' => $clintId,
                                         'status'  => 1,
                                     ));
             return $total_withdrawals;
         }

         /*
        |--------------------------------------------------------------------------
        |protected function get Total Service Charges
        |--------------------------------------------------------------------------
        */

        protected function getTopUpsbyWallet($clintId){
            $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_payment_method=  :funding_payment_method "), 
                                     array(
                                         'client' => $clintId,
                                         'status'  => 1,
                                         'funding_payment_method' => 2,
                                     ));
             return $top_upsby_wallet;  
         }

        
        /*
        |--------------------------------------------------------------------------
        |protected function get Total Client Top-Up
        |--------------------------------------------------------------------------
        */

        protected function getTotalClientTopUp($clintId){
            $total_client_top_up = DB::select( DB::raw("SELECT IFNULL(SUM(funding_amount),0) AS value FROM funding_payment WHERE client=  :client"), 
                                     array(
                                         'client' => $clintId,
                                     ));
             return $total_client_top_up;
         }

         /*
        |--------------------------------------------------------------------------
        |protected function get Total Client Top-Up
        |--------------------------------------------------------------------------
        */

        protected function getUniLevelRewardsTotal($clintId,$fundingType){
            $uni_level_rewards_total = DB::select( DB::raw("SELECT IFNULL(SUM(referral_reward.amount),0) AS value FROM Funding_payment 
           JOIN  funding_payment  ON referral_reward.funding_payment = funding_payment.id
           JOIN  client ON client.id = funding_payment.client
           WHERE referral_reward.client = :client AND  funding_payment.funding_type=  :funding_payment_method" ), 
            array(
                'client' => $clintId,
                'funding_payment_method' =>$fundingType
            ));
             return $uni_level_rewards_total;
         }


        /*
        |--------------------------------------------------------------------------
        |protected function get Main Head Investment
        |--------------------------------------------------------------------------
        */

        protected function getMainInvestment($clintId,  $funding_type){
            $main_investment = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_type = :funding_type"), 
                                    array(
                                        'client' => $clintId,
                                        'status'  => 1,
                                        'funding_type' => $funding_type
                                    ));
            return $main_investment;

        }

        /*
        |--------------------------------------------------------------------------
        |protected function get Total Service charge
        |--------------------------------------------------------------------------
        */
        protected function getTotalServiceCharge($clintId){
            $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_payment_method=  :funding_payment_method "), 
                                    array(
                                        'client' => $clintId,
                                        'status'  => 1,
                                        'funding_payment_method' => 2,
                                    ));
            return $top_upsby_wallet;  
        }
            

        /* 
        |--------------------------------------------------------------------------
        |protected function get auth user details
        |--------------------------------------------------------------------------
        */ 
        protected function getKycDetails($clintId){

            $data = Client::with('getClientTitle','getClientFundSource','getIdentityDocType','getCountry', 'getSelfieImage','getFrontImage','getBackImage')->where('id',$clintId)->first();
            return $data;

        }


        /*
        |--------------------------------------------------------------------------
        |protected function get Total counts to dashboard
        |--------------------------------------------------------------------------
        */
        
        protected function dashboardCounts(){

            $total_initial_funds_up_to_date                     = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 1 AND status = 1"))[0]->value;
            $total_top_up_funds_up_to_date                      = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM `funding_payment` WHERE funding_type = 2 AND status = 1"))[0]->value;
            $total_withdrawals_up_to_date                       = DB::select( DB::raw("SELECT IFNULL(SUM(recieving_amount),0) AS value FROM `withdrawal` WHERE status = 1"))[0]->value;
            $total_initial_funds_service_charges_up_to_date     = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  1 AND status = 1"))[0]->value;
            $total_top_up_funds_service_charges_up_to_date      = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM `funding_payment` WHERE funding_type =  2 AND status = 1"))[0]->value;
            $total_withdrawal_service_charges_up_to_date        = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM `withdrawal` WHERE status = 1"))[0]->value;
            $total_balance_funds = ($total_initial_funds_up_to_date+$total_top_up_funds_up_to_date)-$total_withdrawals_up_to_date;
            
            $response_array = array(
                               'total_initial_funds_up_to_date'=>number_format($total_initial_funds_up_to_date,2),
                               'total_top_up_funds_up_to_date'=>number_format($total_top_up_funds_up_to_date,2),
                               'total_withdrawals_up_to_date'=>number_format($total_withdrawals_up_to_date,2),
                               'total_initial_funds_service_charges_up_to_date'=>number_format($total_initial_funds_service_charges_up_to_date,2),
                               'total_top_up_funds_service_charges_up_to_date'=>number_format($total_top_up_funds_service_charges_up_to_date,2),
                               'total_withdrawal_service_charges_up_to_date'=>number_format($total_withdrawal_service_charges_up_to_date,2),
                               'total_balance_funds'=>number_format($total_balance_funds,2),
                            );

            return $response_array;

       }

    /*
    |--------------------------------------------------------------------------
    |protected function get Total Withdrawl Service charge
    |--------------------------------------------------------------------------
    */
    protected function getTotalWithdrawlServiceCharge($clintId){
        $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM withdrawal WHERE client=  :client AND status = :status"), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                ));
        return $top_upsby_wallet;  
    }
     /*
    |--------------------------------------------------------------------------
    |protected function get User Role
    |--------------------------------------------------------------------------
    */

    protected function getUserRole(){
        $data = UserRole::all();
        return $data;
    }

        /*
    |--------------------------------------------------------------------------
    |protected function get user permition  for edit
    |--------------------------------------------------------------------------
    */ 
    protected function getSelectedUserPermition($role_id){
        $data = UserPermissions::where('role_id',$role_id)->get()->pluck('permission');
        return $data;
        
    }

    protected function getUserRoleByRoleID($id){
        $data = UserRole::where('id',$id)->first();
        return $data;
    }

        /*
    |--------------------------------------------------------------------------
    |protected function get p2p sent
    |--------------------------------------------------------------------------
    */ 
    protected function getP2Psent($clintId){
        $data = P2PTransfer::orderBy('created_at', 'ASC')
        ->with('getTo:id,full_name,membership_no')
       ->where('from',$clintId)
       ->get();
       return $data;
   }
 
    /*
    |--------------------------------------------------------------------------
    |protected function get p2p received
    |--------------------------------------------------------------------------
    */ 
    protected function getP2Preceived($clintId){
        $data = P2PTransfer::orderBy('created_at', 'ASC')
        ->with('getFrom:id,full_name,membership_no')
       ->where('to',$clintId)
       ->get();
       return $data;
   }

   protected function clientReportCounts($client, $start_date,$end_date ){

    $response_array = array(
        'left_chain_heads_count'            => $this->chainHeadsCount(0,$client,$start_date,$end_date),
        'rigth_chain_heads_count'           => $this->chainHeadsCount(1,$client,$start_date,$end_date),
        'left_direct'                       => $this->Direct(0,$client,$start_date,$end_date),
        'rigth_direct'                      => $this->Direct(1,$client,$start_date,$end_date),
        'left_chain_bv'                     => $this->chainBv(0,$client,$start_date,$end_date),
        'rigth_chain_bv'                    => $this->chainBv(1,$client,$start_date,$end_date),
        'left_initial_funds'                => $this->funds(0,1,$client,$start_date,$end_date),
        'rigth_initial_funds'               => $this->funds(1,1,$client,$start_date,$end_date),
        'left_top_ups_funds'                => $this->funds(0,2,$client,$start_date,$end_date),
        'rigth_top_ups_funds'               => $this->funds(1,2,$client,$start_date,$end_date),
        'left_withdrawals_funds'            => $this->fundsWithdrawal(0,$client,$start_date,$end_date),
        'rigth_withdrawals_funds'           => $this->fundsWithdrawal(1,$client,$start_date,$end_date),
        'left_initial_service_charge'       => $this->serviceCharge(0,1,$client,$start_date,$end_date),
        'rigth_initial_service_charge'      => $this->serviceCharge(1,1,$client,$start_date,$end_date),
        'left_top_ups_service_charge'       => $this->serviceCharge(0,2,$client,$start_date,$end_date),
        'rigth_top_ups_service_charge'      => $this->serviceCharge(1,2,$client,$start_date,$end_date),
        'left_withdrawals_service_charge'   => $this->serviceChargeWithdrawal(0,$client,$start_date,$end_date),
        'rigth_withdrawals_service_charge'  => $this->serviceChargeWithdrawal(1,$client,$start_date,$end_date),
        

    );
    return $response_array;

}

private function chainHeadsCount($side,$client,$start_date,$end_date){
    if ($start_date != null && $end_date != null ) {
        return  ClientTeamMap::with('client')->where('parent', $client)->where('side', $side)
        ->whereHas('client', function ($query) use($start_date,$end_date){
            $query->whereBetween('created_at', [$start_date,$end_date]);
        })->count();
        
       
    }else{
        return  ClientTeamMap::with('client')->where('parent', $client)->where('side', $side)->count();
    }
    
}

private function Direct($side,$client,$start_date,$end_date){
    if ($start_date != null && $end_date != null ) {
        return  Client::where('sponsor', $client)->where('sponsor_side', $side)->whereBetween('created_at', [$start_date,$end_date])->count();
    }else{
        return  Client::where('sponsor', $client)->where('sponsor_side', $side)->count();
    }
   
}

private function chainBv($side,$client,$start_date,$end_date){

    if ($start_date != null && $end_date != null ) {
        return  DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.trading_amount),0) AS value FROM client_team_map 
                    JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                    WHERE client_team_map.side = $side AND client_team_map.parent=  :client
                    And funding_payment.approved_date between '$start_date' AND '$end_date' " ), 
                    array(
                        'client' => $client,
                ));
        }else{
            return  DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.trading_amount),0) AS value FROM client_team_map 
                        JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                        WHERE client_team_map.side = $side AND client_team_map.parent=  :client" ), 
                        array(
                            'client' => $client,
            ));

        }
    }
    
private function funds($side,$funding_type,$client,$start_date,$end_date){

    if ($start_date != null && $end_date != null ) {
        return DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.trading_amount),0) AS value FROM client_team_map 
                        JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                        WHERE client_team_map.side = $side AND funding_payment.funding_type = $funding_type AND  client_team_map.parent=  :client
                        And funding_payment.approved_date between '$start_date' AND '$end_date'" ), 
                        array(
                            'client' => $client,
                        ));
    }else {
        return DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.trading_amount),0) AS value FROM client_team_map 
                            JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                            WHERE client_team_map.side = $side AND funding_payment.funding_type = $funding_type AND  client_team_map.parent=  :client
                            And approved_date between '$start_date' AND '$end_date'" ), 
                            array(
                                'client' => $client,
                            ));
    }
   
}

private function fundsWithdrawal($side,$client,$start_date,$end_date){
    if ($start_date != null && $end_date != null ) {
        return DB::select( DB::raw("SELECT IFNULL(SUM(withdrawal.withdraw_amount),0) AS value FROM client_team_map 
                        JOIN  withdrawal ON withdrawal.client = client_team_map.child 
                        WHERE client_team_map.side = $side AND  client_team_map.parent=  :client
                        And withdrawal.approved_date between '$start_date' AND '$end_date'" ), 
                        array(
                            'client' => $client,
                        ));
    }else {
        return DB::select( DB::raw("SELECT IFNULL(SUM(withdrawal.withdraw_amount),0) AS value FROM client_team_map 
                        JOIN  withdrawal ON withdrawal.client = client_team_map.child 
                        WHERE client_team_map.side = $side AND  client_team_map.parent=  :client" ), 
                        array(
                            'client' => $client,
                        ));
    }
   
}

private function serviceCharge($side,$funding_type,$client,$start_date,$end_date){
    if ($start_date != null && $end_date != null ) {
        return DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.service_charge),0) AS value FROM client_team_map 
                    JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                    WHERE client_team_map.side = $side AND funding_payment.funding_type = $funding_type AND  client_team_map.parent=  :client
                    And funding_payment.approved_date between '$start_date' AND '$end_date'" ), 
                    array(
                        'client' => $client,
                    ));

    }else{
        return DB::select( DB::raw("SELECT IFNULL(SUM(funding_payment.service_charge),0) AS value FROM client_team_map 
                    JOIN  funding_payment ON funding_payment.client = client_team_map.child 
                    WHERE client_team_map.side = $side AND funding_payment.funding_type = $funding_type AND  client_team_map.parent=  :client" ), 
                    array(
                        'client' => $client,
                    ));
    }
}

private function serviceChargeWithdrawal($side,$client,$start_date,$end_date){
    if ($start_date != null && $end_date != null ) {
        return DB::select( DB::raw("SELECT IFNULL(SUM(withdrawal.transaction_fee),0) AS value FROM client_team_map 
                    JOIN  withdrawal ON withdrawal.client = client_team_map.child 
                    WHERE client_team_map.side = $side AND  client_team_map.parent=  :client
                    And withdrawal.approved_date between '$start_date' AND '$end_date'" ), 
                    array(
                        'client' => $client,
                    ));
    }else {   
    return DB::select( DB::raw("SELECT IFNULL(SUM(withdrawal.transaction_fee),0) AS value FROM client_team_map 
                JOIN  withdrawal ON withdrawal.client = client_team_map.child 
                WHERE client_team_map.side = $side AND  client_team_map.parent=  :client" ), 
                array(
                    'client' => $client,
                ));
       
    }


}

/*
    |--------------------------------------------------------------------------
    |protected function get Identity Doc Types
    |--------------------------------------------------------------------------
    */ 
    protected function getIdentityDocTypes(){

        $data = IdentityDocType::all();
        return $data;
    }








}






