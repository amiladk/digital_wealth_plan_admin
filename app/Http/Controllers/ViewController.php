<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Models\PersonalDetails;
use App\Models\Funding_payment;
use App\Models\Client;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Source;
use App\Models\CryptoNetwork;
use App\Models\CurrencyType;
use App\Models\TransactionSettings;
use App\Models\ClientWallet;
use App\Models\P2PTransfer;
use App\Models\UserRole;

use DB;
use Auth;


// class ViewController extends Controller
class ViewController extends DataController

{
    public function default($data)
    {   
        // Defalut css
        $css =array(
            config('site-specific.choices-min-css'),
            config('site-specific.flatpickr-min-css'),
            config('site-specific.preloader-min-css'),
            config('site-specific.bootstrap-min-css'),
            config('site-specific.icons-min-css'),
            config('site-specific.jquery-jvectormap-css'),
            config('site-specific.app-min-css'),
            config('site-specific.dataTables-bootstrap4-min-css'),
            config('site-specific.buttons-bootstrap4-min-css'),
            config('site-specific.responsive-bootstrap4-min-css'),
            config('site-specific.sweetalert-css'),
            config('site-specific.custom-style-css'),
        );

        //Default script
        $script =array(
                        
            config('site-specific.jquery-min-js'),
            config('site-specific.sweetalert-js'),
            config('site-specific.bootstrap-bundle-min-js'),
            config('site-specific.metisMenu-min-js'),
            config('site-specific.simplebar-min-js'),
            config('site-specific.waves-min-js'),
            config('site-specific.feather-min-js'),
            config('site-specific.pace-min-js'),
            config('site-specific.choices-min-js'),
            config('site-specific.pass-addon-init-js'),
            // config('site-specific.apexcharts-min-js'),
            // config('site-specific.jquery-jvectormap-1-2-2-min-js'),
            // config('site-specific.jquery-jvectormap-world-mill-en-js'),
            //config('site-specific.dashboard-init-js'),
            config('site-specific.app-js'),
            config('site-specific.jquery-dataTables-min-js'),
            config('site-specific.dataTables-bootstrap4-min-js'),
            config('site-specific.dataTables-buttons-min-js'),
            config('site-specific.buttons-bootstrap4-min-js'),
            config('site-specific.jszip-min-js'),
            config('site-specific.pdfmake-min-js'),
            config('site-specific.vfs_fonts-js'),
            config('site-specific.buttons-html5-min-js'),
            config('site-specific.buttons-print-min-js'),
            config('site-specific.buttons-colVis-min-js'),
            config('site-specific.dataTables-responsive-min-js'),
            config('site-specific.responsive-bootstrap4-min-js'),
            config('site-specific.datatables-init-js'),
            config('site-specific.sweetalert-js'),
            // config('site-specific.modal-init-js'), 
        );

        if(isset($data['css'])){
            $data['css'] = array_merge($css,$data['css']);
        }else{
            $data['css'] = $css;
        }
        if(isset($data['script'])){
            $data['script'] = array_merge($script,$data['script']);
        }else{
            $data['script'] = $script;
        }

        return View::make('template', $data);
    }



     public function login(Request $request)
    { 
        return View::make('login');
    }

    

    public function dashbord(Request $request)
    {
         
        $total_users = Client::count();
        $data =array(
            'title'                                                 => 'Dashbord',
            'view'                                                  => 'dashbord',
            'css'                                                   => array(config('site-specific.classic-min-css'),config('site-specific.monolith-min-css'),config('site-specific.flatpickr-min-css')),
            'script'                                                => array(config('site-specific.pickr.min.js'),
                                                                            config('site-specific.pickr.es5.min.js'),
                                                                            config('site-specific.flatpickr-min-js'),
                                                                            config('site-specific.dashboard-init-js')
                                                                            ),
            'total_users'                                           => $total_users,
            'funding_payments'                                      => Funding_payment::where('status',0)->count(),
            'pending_kycs'                                          => Client::where('kyc_status',0)->count(),
            'pending_withdraws'                                     => Withdrawal::where('status',0)->count(),
            'total_initial_funds'                                   => Funding_payment::where('status',1)->where('funding_type',1)->count(),
            'total_top_ups'                                         => Funding_payment::where('status',1)->where('funding_type',2)->count(),
            'total_counts'                                          => $this->dashboardCounts(),
        );
       return $this->default($data);
    //    return response()->json($total_users);
       
    }

    public function pendingpurchases(Request $request)
    {
      
        $data =array(
            'title'             =>'Pending Purchases',
            'view'              => 'pending-purchases',
            'css'               => array(),
            'script'            => array(config('site-specific.custom-init-js'),config('site-specific.pending-purchases-init-js')),
            // 'funding_payments'  => Funding_payment::with(['getImage'],['getClient'],['getFundingPaymentMethod'],['User'])->where('status',$request->status)->get(),
            // 'status'            => $request->status,
        );
       return $this->default($data);
    }

    public function pendingkyc(Request $request)
    {
       
        $data =array(
            'title'             => 'Pending KYCs',
            'view'              => 'pending-kyc', 
            'css'               => array(),
            'script'            => array(config('site-specific.custom-init-js'),config('site-specific.pending-kyc-init-js')),
            // 'pending_kyc'       => Client::with('getSponsor','getCountry','getSelfieImage','getFrontImage','getBackImage','User')->where('kyc_status',$request->status)->get(),
            // 'status'            => $request->status,
        );
        // return response()->json( $data['pending_kyc']);
       return $this->default($data);
    }
    

    public function pendingwithdraw(Request $request)
    {
       
        $data =array(
            'title'             => 'Pending withdrawals',
            'view'              => 'pending-withdraw',
            'css'               => array(),
            'script'            => array(config('site-specific.custom-init-js'),config('site-specific.pending-withdrawals-init-js')),
            // 'pending_withdraws' => Withdrawal::with('getClient','currencyType','cyptoNetwork','User')->where('status',$request->status)->get(),
            // 'status'            => $request->status,
        );
        // return response()->json( $data['pending_withdraws']);
       return $this->default($data);
    }
 

    public function clientList(Request $request)
    {
       
        $data =array(
            'title'             => 'Client List',
            'view'              => 'client-list',
            'css'               => array(),
            'script'            => array(config('site-specific.client-list-init-js')),
           // 'client_list'       => $clint

        );
       // return response()->json($data['client_list']);
       return $this->default($data);
    }


    public function clientSummary($id)
    {
        
        $clintId = $id;
        $client   = Client::find($clintId);
        if (!$client) {
            return redirect()->route('client-list')->with('error',"Client Not Found!" );
        }
            $total_left_bv           = $this->getTotalBvSide($clintId,0);
            $total_right_bv          = $this->getTotalBvSide($clintId,1);
            $balanced_bv             = min($total_left_bv[0]->value,$total_right_bv[0]->value);
            $left_after_bv_balance   = $total_left_bv[0]->value - $balanced_bv ;
            $right_after_bv_balance   = $total_right_bv[0]->value - $balanced_bv ;
            $main_head_investment      = $this->getMainInvestment($clintId,1);
            $total_top_up_Investments  = $this->getMainInvestment($clintId,2);
            $total_investments         = $main_head_investment[0]->value + $total_top_up_Investments[0]->value;
            $top_upsby_wallet          = $this->getTopUpsbyWallet($clintId);
            $total_withdrawals         = $this->getTotalWithdrawals($clintId);
            $total_client_top_up       = $this->getTotalClientTopUp($clintId);
            $total_service_charge      = $this->getTotalServiceCharge($clintId);
            $total_withdrawl_service_charge = $this->getTotalWithdrawlServiceCharge($clintId);
            
        $data =array(
            'title'                     => 'client summary',
            'view'                      => 'client-summary',
            'css'                       => array(config('site-specific.dataTables-bootstrap4-min-css'),
                                                    config('site-specific.buttons-bootstrap4-min-css'),
                                                    config('site-specific.responsive-bootstrap4-min-css')),
            'script'                    => array(config('site-specific.jquery-dataTables-min-js'),
                                                    config('site-specific.dataTables-bootstrap4-min-js'),
                                                    config('site-specific.dataTables-buttons-min-js'),
                                                    config('site-specific.buttons-bootstrap4-min-js'),
                                                    config('site-specific.jszip-min-js'),
                                                    config('site-specific.pdfmake-min-js'),
                                                    config('site-specific.vfs_fonts-js'),
                                                    config('site-specific.buttons-html5-min-js'),
                                                    config('site-specific.buttons-print-min-js'),
                                                    config('site-specific.buttons-colVis-min-js'),
                                                    config('site-specific.dataTables-responsive-min-js'),
                                                    config('site-specific.responsive-bootstrap4-min-js'),),
            'client_top_ups'            => $this->getMyFundingPayment($clintId),
            'client_withdrawals'        => $this->getWithdrawal($clintId),
            'unilevel_funding_rewards'  => $this->getUniLevelRewards($clintId,1),
            'unilevel_topup_rewards'    => $this->getUniLevelRewards($clintId,2),
            'bv_rewards'                => $this->getBvRewards($clintId),
            'daily_rewards'             => $this->getDailyRewards($clintId),
            'bv_elegibilty'             => $this->getBvElegibility($clintId),
            'client'                    => $client,
            'total_left_chain_bv'       => number_format($total_left_bv[0]->value,2),
            'total_right_chain_bv'      => number_format($total_right_bv[0]->value,2),
            'blance_bv'                 => number_format($balanced_bv,2),
            'left_after_bv_balance'     => number_format($left_after_bv_balance,2),
            'right_after_bv_balance'    => number_format($right_after_bv_balance,2),
            'reward_counts'             => $this->rewardsCounts($clintId),
            'total_withdrawals'         => $this->getTotalWithdrawals($clintId),
            'total_client_top_up'       => number_format($total_client_top_up[0]->value,2),
            'total_withdrawals'         => number_format($total_withdrawals[0]->value,2),
            'top_upsby_wallet'          => number_format($top_upsby_wallet[0]->value,2),
            'main_head_investment'      => number_format($main_head_investment[0]->value,2),
            'total_top_up_Investments'  => number_format($total_top_up_Investments[0]->value,2),
            'total_investments'         => number_format($total_investments,2),
            'total_holding_balance'     => number_format($client->holding_wallet,2), 
            'total_available_balance'   => number_format($client->wallet,2),
            'total_service_charge'      => number_format($total_service_charge [0]->value,2), 
            'user_details'              => $this->getKycDetails($clintId),
            'total_withdrawl_service_charge' => number_format($total_withdrawl_service_charge [0]->value,2),
            'left_user_direct_count'    => Client::where('sponsor',$clintId)->where('sponsor_side', 0)->count(),
            'right_user_direct_count'   => Client::where('sponsor',$clintId)->where('sponsor_side', 1)->count(),
            'p2p_sent'                  => number_format(P2PTransfer::where('from',$clintId)->sum('received_amount'),2),
            'p2p_received'              => number_format(P2PTransfer::where('to',$clintId)->sum('received_amount'),2),
            'p2p_sent_details'          => $this->getP2Psent($clintId),
            'p2p_received_details'      => $this->getP2Preceived($clintId),
            // 'unilevel_rewards_total'    => $this->getUniLevelRewardsTotal($clintId,1),
        );

        // return response()->json($data['client_top_ups']);
        return $this->default($data);

    }


    public function editClient(Request $request)
    {
        $data =array(
            'title'                 => 'Edit Client',
            'view'                  => 'edit_client',
            'css'                   => array(config('site-specific.mobiscroll-javascript-min-css'),
                                            config('site-specific.intlTelInput-css'),
                                            config('site-specific.cropper-min-css')),
            'script'                => array(config('site-specific.mobiscroll-javascript-min-js'),
                                            config('site-specific.intlTelInput-min-js'),
                                            config('site-specific.custom-js'),
                                            config('site-specific.form-advanced-init-js'),
                                            config('site-specific.pristine-min-js'),
                                            config('site-specific.form-advanced-init-js'),
                                            config('site-specific.form-validation.init-js'),
                                            config('site-specific.edit_client-js'),
                                            config('site-specific.cropper-min-js')),
                                            
            'client_titles'         => PersonalDetails::all(),
            'client_fund_sources'   => Source::all(),
            'client'                => Client::with('getCountry','getSelfieImage','getFrontImage','getBackImage')->where('id',$request->id)->first(),
            'identity_doc_types'=> $this->getIdentityDocTypes(),
        );
        // return response()->json($data['client']);
       return $this->default($data);
    }


    public function userCreate(Request $request)
    {    
        $data =array(
            'title'             => 'User Create',
            'view'              => 'user_create',
            'css'               => array(),
            'script'            => array(config('site-specific.custom-js')),
            'user_role'         => $this->getUserRole(),
        );
       return $this->default($data);
       
    }

    public function userEdit(Request $request)
    {    
        $data =array(
            'title'             => 'User Edit',
            'view'              => 'user_edit',
            'css'               => array(),
            'script'            => array(config('site-specific.custom-js')),
            'user_role'         => $this->getUserRole(),
            'selected_user'     => User::with('getUserRole')->where('id',$request->id)->first(),    
        );

       return $this->default($data);
       
    }

    public function userList(Request $request)
    {    
        $data =array(
            'title'             => 'User List',
            'view'              => 'user_list',
            'css'               => array(),
            'script'            => array(),
            'users'             => User::with('getUserRole')->get(),
        );
        // return response()->json($data['users']);
       return $this->default($data);
       
    }

    public function cryptoNetwork(Request $request)
    {    
        $data =array(
            'title'                 => 'Crypto Network',
            'view'                  => 'crypto-network',
            'css'                   => array(),
            'script'                => array(config('site-specific.crypto-network-init')),
            'client_wallet'         => ClientWallet::all('id'),
            'crypto_networks'       => CryptoNetwork::all(),
        );
       return $this->default($data);
       
    }

    public function currencyType(Request $request)
    {    
        $data =array(
            'title'                 => 'Currency Type',
            'view'                  => 'currency-type',
            'css'                   => array(config('site-specific.select2-min-css')),
            'script'                => array(config('site-specific.select2-min-js'),config('site-specific.currency-type-init')),
            'crypto_network'        => CryptoNetwork::all(),
            'currency_types'        => CurrencyType::with('networkMap.cryptoNetwork')->get(),
            
        );

        //return response()->json($data['currency_types']);
       return $this->default($data);
       
    }

    public function transactionSettings(Request $request)
    {    
        $data =array(
            'title'                     => 'Transaction Settings',
            'view'                      => 'transaction-settings',
            'css'                       => array(),
            'script'                    => array(config('site-specific.crypto-network-init')),
            'transaction_settings'      => TransactionSettings::all(),
        );
       return $this->default($data);
       
    }

    public function userRoles(Request $request)
    {     
        $data =array(
            'title'             => 'User role Create',
            'view'              => 'user_role_create',
            'css'               => array(),
            'script'            => array(config('site-specific.user-role-js')), 
           
        );
       return $this->default($data);   
    }

    public function userRoleList(Request $request)
    {    
        
        $data =array(
            'title'             => 'User Role List',
            'view'              => 'user_role_list',
            'css'               => array(),
            'script'            => array('site-specific.user-role-js'),
            'user_role'         => UserRole::all(),
        );
        // return response()->json($data['user_role']);
       return $this->default($data);
       
    }

    public function userRoleEdit(Request $request)
    {    
        
        $data =array(
            'title'             => 'User Role Edit',
            'view'              => 'user_role_edit',
            'css'               => array(),
            'script'            => array(config('site-specific.user-role-js')),
            'user_role'         => $this->getUserRoleByRoleID($request->id),
            'user_permission'   => $this->getSelectedUserPermition($request->id),
        );
        // return response()->json($data['user_role']);
       return $this->default($data);
       
    }

    public function ClientReport(Request $request)
    {

        $start_date = ($request->has('start_date'))? $request->start_date : null;
        $end_date   = ($request->has('end_date'))? $request->end_date : null;
        $client     = ($request->has('client'))? $request->client : null;
        $selected_date_rage = null;
        if($start_date != null &&  $end_date != null){
            $selected_date_rage = $start_date.' to '.$end_date;
        }

        //dd($start_date);
      
        $data =array(
            'title'                 => 'Client Report',
            'view'                  => 'client-report',
            'css'                   => array(config('site-specific.select2-min-css')),
            'script'                => array(config('site-specific.select2-min-js'),
                                            config('site-specific.pickr.min.js'),
                                            config('site-specific.pickr.es5.min.js'),
                                            config('site-specific.flatpickr-min-js'),
                                            config('site-specific.client-report-init-js')),
            'client'                => Client::all(),
            'selected_date_rage'    => $selected_date_rage,
            'selected_client'       => $client,
            'clientReportCounts'    => $this->clientReportCounts($client,$start_date,$end_date )
        );
       return $this->default($data);
    //    return response()->json($data['client']);
    // 


}

public function p2pTransfer(Request $request)
{
    
    $data =array(
        'title'             => 'P2P Transfer',
        'view'              => 'p2p-transfer',
        'css'               => array(),
        'script'            => array(config('site-specific.custom-init-js'),config('site-specific.p2p-transfer-init-js')),
      
    );
   return $this->default($data);
}

public function liabilityReport(Request $request)
{
    
    $data =array(
        'title'             => 'Funding Wise Liability Report',
        'view'              => 'liability-report',
        'css'               => array(),
        'script'            => array(config('site-specific.custom-init-js'),config('site-specific.liability-report-init-js')),
      
    );
   return $this->default($data);
}

public function liabilityReportClientWise(Request $request)
{
    
    $data =array(
        'title'             => 'Client Wise Liability Report',
        'view'              => 'liability-report-client-wise',
        'css'               => array(),
        'script'            => array(config('site-specific.custom-init-js'),config('site-specific.liability-report-client-wise-init-js')),
      
    );
   return $this->default($data);
}




}