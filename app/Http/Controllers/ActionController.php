<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Response;
use Validator;
use Throwable;
use Carbon\Carbon;
use Mail;
use Auth;

use App\Models\Withdrawal;
use App\Models\Client;
use App\Models\User;
use App\Models\Funding_payment;
use App\Models\Country;
use App\Models\CurrencyType;
use App\Models\CurrencyNetworkMap;
use App\Models\CryptoNetwork;
use App\Models\TransactionSettings;
use App\Models\UserRole;
use App\Models\UserPermissions;


class ActionController extends Controller
{
  
    /*
    |--------------------------------------------------------------------------
    | Public function / Disapprove
    |--------------------------------------------------------------------------
    */ 
    public function withdrawDisapprove(Request $request){

        try {
           
            $validator = Validator::make($request->all(), [
                'id'                => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('pending-withdraw')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

                $withdrawal = Withdrawal::find($request->id);
                $withdrawal->status             = 2;
                $withdrawal->approved_date      = Carbon::now();
                $withdrawal->approved_by        = Auth::user()->id;
                $withdrawal->save();

                $this->updateWallets([$withdrawal->client]);

            DB::commit();

            return redirect()->back()->with('success', 'Pending Withdraw status updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    public function purchasesDisapprove(Request $request){

        try {
           
            $validator = Validator::make($request->all(), [
                'id'                => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('pending-purchases')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

                $purchases = Funding_payment::find($request->id);
                $purchases->status         = 2;
                $purchases->approved_date  = Carbon::now();
                $purchases->approved_by   = Auth::user()->id;
                $purchases->save();

                $this->updateWallets([$purchases->client]);

            DB::commit();

            return redirect()->back()->with('success', 'Pending Purchases status updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    public function kycDisapprove(Request $request){

        try {
           
            $validator = Validator::make($request->all(), [
                'id'                => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('pending-kyc')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

                $kyc = Client::find($request->id);
                $kyc->kyc_status         = 2;
                $kyc->kyc_approved_date  = Carbon::now();
                $kyc->kyc_approved_by  = Auth::user()->id;
                $kyc->save();
  
            DB::commit();

            return redirect()->back()->with('success', 'Pending KYC status updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    
/*
|--------------------------------------------------------------------------
| Approve Kyc
|--------------------------------------------------------------------------
*/

public function approvePendingKyc(Request $request){

    try {
       
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('pending-kyc')->with('error', implode(" / ",$validator->messages()->all()));
        }

        DB::beginTransaction($validator);

            $kyc = Client::find($request->id);
            $kyc->kyc_status                = 1;
            $kyc->kyc_approved_date         = Carbon::now();
            $kyc->kyc_approved_by  = Auth::user()->id;
            $kyc->save();

        DB::commit();

        return redirect()->back()->with('success', 'Pending KYC status updated successfully!');

    } 
    catch (\Throwable $e){
        DB::rollback();
        return redirect()->back()->with('error', "Something went wrong. Please try again later!");
    }

}

/*
|--------------------------------------------------------------------------
| Approve Withdrawal
|--------------------------------------------------------------------------
*/

public function approveWithdrawal(Request $request)
{

    try {
       
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
        ]);

        if($validator->fails()){
            return array('success'=>false,'data'=>null, 'msg'=> implode(" / ",$validator->messages()->all()));
        }

        DB::beginTransaction($validator);

            $withdrawal = Withdrawal::with('getClient')->where('id',$request->id)->first();
            $withdrawal->status             = 1;
            $withdrawal->approved_date      = Carbon::now();
            $withdrawal->approved_by        = Auth::user()->id;
            $withdrawal->save();

            $this->updateWallets([$withdrawal->client]);

        DB::commit();
        $this->sendEmail('Approved Withdrawal',$withdrawal->getClient->email,'email-withdrawal-approval',$withdrawal);
        return array('success'=>true,'data'=>null, 'msg'=> 'Pending Withdraw status updated successfully!');
    }  
    catch (\Throwable $e){
        DB::rollback();
        return array(
            'success' =>false,
            'data'=>null,
            'msg' => $e->getMessage()
        );
        return redirect()->back()->with('error', "Something went wrong. Please try again later!");
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


    /*
    |--------------------------------------------------------------------------
    | Public function / Edit Client
    |--------------------------------------------------------------------------
    */    
    public function clientEdit(Request $request){
        // return response()->json($request->all());

        try {
            $validation_array = [
                'first_name'                => 'required',
                'last_name'                 => 'required',
                'country'                   => 'required',
                'email'                     => 'required|email', 
                'client_title'              => 'required',
                'full_name'                 => 'required',
                'dob'                       => 'required',
                'phone_number'              => 'required',
                'address'                   => 'required',
                'client_fund_source'        => 'required',
                'is_active'                 => 'nullable', 
            ];

            if(isset($_POST['change_login_details'])){
                $validation_array['password'] = 'required|confirmed';
                $validation_array['password_confirmation'] = 'required';
            }

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('edit-client',$request->id)->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            //checking country exists in country table and inserting if not
            $country = Country::where('name', $request->country)->first();

            if($country){
                $country = $country->id;
            }else{
                $country = Country::create(['name'=>$request->country]);
                $country = $country->id;
            }

            $is_active = 0;
            if(isset($_POST['is_active'])){
                $is_active = 1;
            }

            $client = Client::find($request->id);

            $client->id                     = $request->id;
            $client->first_name             = $request->first_name;
            $client->last_name              = $request->last_name;
            $client->country                = $country;
            $client->email                  = $request->email;
            $client->client_title           = $request->client_title;
            $client->full_name              = $request->full_name;
            $client->dob                    = $request->dob;
            $client->phone_number           = $request->phone_number;
            $client->address                = $request->address;
            $client->client_fund_source     = $request->client_fund_source;
            $client->is_active              = $is_active;
            if(isset($_POST['change_login_details'])){
                $client->password           = bcrypt($request->password);
            }

            $client->save();

            DB::commit();
    
            return redirect()->back()->with('success', 'Client Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Public function Calculate and insert daily rewards
    |--------------------------------------------------------------------------
    */  
    public function calculateDailyRewards(){
        try {
            date_default_timezone_set("Asia/Colombo");
            $date_now = date("Y-m-d");
            $last_daily_reward_date = (DB::table('site_settings')->where('field','last_daily_reward_date')->first())->value;
            if($last_daily_reward_date < $date_now){
                DB::beginTransaction();
                $diff=date_diff(date_create($last_daily_reward_date),date_create($date_now));
                $x = 0;
                while($x < $diff->d) {
                    $date=date_create($last_daily_reward_date);
                    date_add($date,date_interval_create_from_date_string(($x+1)." days"));
                    $reward_date = date_format($date,"Y-m-d");
                    $this->updateDailyRewards($reward_date);
                    $x++;
                }

                DB::table('site_settings')->where('field','last_daily_reward_date')->update(['value' => $date_now]);
                DB::commit();
                return true;
            }else{
                return false;
            }
        }catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }



    private function updateDailyRewards($reward_date){

        $funding_payment  = Funding_payment::where('status',1)->where('daily_rewards_completed',0)->get();

        foreach($funding_payment as $data){
            //7 days delay
            // $date_now = date("Y-m-d");
            $diff=date_diff(date_create($data->approved_date),date_create($reward_date));
            $diff=(int)$diff->format("%R%a");
            if ($diff < 7) {
                continue;
            }

            $rewards_amount = $data->daily_reward_amount + $data->achieved_rewards;
            if($data->daily_reward_limit <= $rewards_amount){
                $update_amount  =  $data->daily_reward_limit - $data->achieved_rewards;
                $rewards_amount =  $data->daily_reward_limit;
                $data->daily_rewards_completed = 1;
                if ($update_amount < 0) {
                    $data->save();
                    continue;
                }
            }
            else{
                $update_amount = $data->daily_reward_amount;
            }

            $data->achieved_rewards = $rewards_amount;
            $data->save();

            DB::table('daily_reward')->insert(
                array(
                    'client'         => $data->client, 
                    'funding_payment'=> $data->id,
                    'reward_date'    => $reward_date,
                    'amount'         => $update_amount,
                )
            );
            $this->updateWallets([$data->client]);
        }

    }

    //migration adjusment functions
    public function calculateClientWallets(Request $request)
    {
        return $this->updateWallets([$request->id]);
        return 1;
    }

    public function calcAllClientWallets(){
        $client_ids = Client::all()->pluck('id')->toArray();
        $this->updateWallets($client_ids);
    }

    /*
    |--------------------------------------------------------------------------
    | Public function / user create form
    |--------------------------------------------------------------------------
    */ 
    public function userCreateForm(Request $request){
        // return response()->json($request->all());

        try {
           
            $validator = Validator::make($request->all(), [
                'name'                      => 'required',
                'address'                   => 'required',
                'nic'                       => 'required',
                'email'                     => 'required|email|unique:App\Models\User',   
                'password'                  => 'required|confirmed|min:6',
                'password_confirmation'     => 'required',
                'user_role'                 => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('user-create')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

            $user = User::create(array_merge(
                $validator->validated(),
                [
                    'password' => bcrypt($request->password),
                ]
            )); 

            DB::commit();

            return redirect()->route('user-edit',$user->id)->with('success', 'User created successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            // return redirect()->back()->with('error', $e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Public function / user edit form
    |--------------------------------------------------------------------------
    */ 
    public function userEditForm(Request $request){

        try {
            $validation_array = [
                'name'                      => 'required',
                'address'                   => 'required',
                'nic'                       => 'required',
                'email'                     => 'required|email', 
                'user_role'           => 'required',  
            ];

            if(isset($_POST['change_login_details'])){
                $validation_array['password'] = 'required|confirmed';
                $validation_array['password_confirmation'] = 'required';
            }

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('user-edit',$request->id)->with('error', implode(" / ",$validator->messages()->all()));
            }
          
            DB::beginTransaction();
           
            $user = User::find($request->id);

            $user->name                 = $request->name;
            $user->address              = $request->address;
            $user->user_role            = $request->user_role;
            $user->nic                  = $request->nic;
            $user->email                = $request->email;
            $user->password             = bcrypt($request->password);
            $user->save();

            DB::commit();
    
            return redirect()->back()->with('success', 'User Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Public function / currency type create form
    |--------------------------------------------------------------------------
    */ 
    public function currencyTypeCreate(Request $request){

        try {
           
            $validator = Validator::make($request->all(), [
                'title'                    => 'required',
                'cypto_network'            => 'required',
                'is_active'                => 'nullable',
            ]);

            if($validator->fails()){
                return redirect()->route('currency-type')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

            $is_active = 0;
            if(isset($_POST['is_active'])){
                $is_active = 1;
            }

            $currency_type = CurrencyType::create(array_merge(
                $validator->validated(),
                [
                    'is_active' => $is_active,
                ]
            )); 

            if($request->has('cypto_network')){

                foreach($request->cypto_network as $key => $data){

                    $values = array(
                                'currency_type'     => $currency_type->id,
                                'crypto_network'    => $data,
                            );

                    CurrencyNetworkMap::insert($values);
                }
            }

            DB::commit();

            return redirect()->route('currency-type')->with('success', 'Currency Type created successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function /currency type edit form
    |--------------------------------------------------------------------------
    */ 
    public function currencyTypeEdit(Request $request){

        try {
            $validation_array = [
                'title'                    => 'required',
                'cypto_network'            => 'required',
                'is_active'                => 'nullable',  
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('currency-type')->with('error', implode(" / ",$validator->messages()->all()));
            }
          
            DB::beginTransaction();
           
            $currency_type = CurrencyType::find($request->id);

            $is_active = 0;
            if(isset($_POST['is_active'])){
                $is_active = 1;
            }

            $currency_type->title                = $request->title;
            $currency_type->is_active            = $is_active;
            $currency_type->save();

            CurrencyNetworkMap::where('currency_type',$currency_type->id)->delete();

            if($request->has('cypto_network')){

                foreach($request->cypto_network as $key => $data){

                    $values = array(
                                'currency_type'    => $currency_type->id,
                                'crypto_network'   => $data,
                            );

                    CurrencyNetworkMap::insert($values);
                }
            }

            DB::commit();
    
            return redirect()->back()->with('success', 'Currency Type Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Public function / crypto network create form
    |--------------------------------------------------------------------------
    */ 
    public function cryptoNetworkCreate(Request $request){
            // return  response()->json($request->all());
        try {
           
            $validator = Validator::make($request->all(), [
                'title'                         => 'required',
                'network_fee'                   => 'required',
                'withdrawal_fee'                => 'required',
                'client_wallet'                 => 'nullable',
                'company_wallet_address'        => 'required',
                'is_active'                     => 'nullable',
            ]);

            if($validator->fails()){
                return redirect()->route('crypto-network')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

            $is_active = 0;
            if(isset($_POST['is_active'])){
                $is_active = 1;
            }
            $client_wallet = 0;
            if(isset($_POST['client_wallet'])){
                $client_wallet = 1;
            }

            $currency_type = CryptoNetwork::create(array_merge(
                $validator->validated(),
                [
                    'is_active'     => $is_active,
                    'client_wallet' => $client_wallet,
                ]
            )); 

            DB::commit();

            return redirect()->route('crypto-network')->with('success', 'Crypto Network created successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            // return redirect()->back()->with('error', $e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function /crypto network edit form
    |--------------------------------------------------------------------------
    */ 
    public function cryptoNetworkEdit(Request $request){

        try {
            $validation_array = [
                'title'                         => 'required',
                'network_fee'                   => 'required',
                'withdrawal_fee'                => 'required',
                'client_wallet'                 => 'nullable',
                'company_wallet_address'        => 'required',
                'is_active'                     => 'nullable', 
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('crypto-network')->with('error', implode(" / ",$validator->messages()->all()));
            }
          
            DB::beginTransaction();
           
            $crypto_network = CryptoNetwork::find($request->id);

            $is_active = 0;
            if(isset($_POST['is_active'])){
                $is_active = 1;
            }
            $client_wallet = 0;
            if(isset($_POST['client_wallet'])){
                $client_wallet = 1;
            }

            $crypto_network->title                          = $request->title;
            $crypto_network->network_fee                    = $request->network_fee;
            $crypto_network->withdrawal_fee                 = $request->withdrawal_fee;
            $crypto_network->client_wallet                  = $client_wallet;
            $crypto_network->company_wallet_address         = $request->company_wallet_address;
            $crypto_network->is_active                      = $is_active;
            $crypto_network->save();

            DB::commit();
    
            return redirect()->back()->with('success', 'Crypto Network Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Public function /transaction settings edit form
    |--------------------------------------------------------------------------
    */ 
    public function transactionSettings(Request $request){

        try {
            $validation_array = [
                'value'                         => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('transaction-settings')->with('error', implode(" / ",$validator->messages()->all()));
            }
          
            DB::beginTransaction();

            foreach($request->value as $key => $data){

                $transaction_settings = TransactionSettings::find($request->id[$key]);
                $transaction_settings->value                      = $data;
                $transaction_settings->save();
            }

            DB::commit();
    
            return redirect()->back()->with('success', 'Transaction Settings Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    
    /*
    |--------------------------------------------------------------------------
    | Public function /user Roel Create 
    |--------------------------------------------------------------------------
    */ 
    public function createUserRole(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'role_name'      => 'required',
                'description'     => 'required', 
            ]);

            if($validator->fails()){
                return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
            }
            DB::beginTransaction();

                $create_id  = UserRole::create(['user_role'=>$request->role_name, 'description' =>$request->description,]);
                $this->addUserRoel($request->permission,$create_id->id );

            DB::commit();
    
            return redirect()->back()->with('success', 'Transaction Settings Edit updated successfully!');

        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    |private function edit User Role
    |--------------------------------------------------------------------------
    */ 
    public function editUserRole(Request $request){
        ;
                try {
                   
                    $validator = Validator::make($request->all(), [
                        'role_name'      => 'required',
                        'description'     => 'required', 
                    ]);
        
                    if($validator->fails()){
                        return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
                    }
        
                   DB::beginTransaction($validator);
        
                        UserRole::where('id',$request->role_id)->update(['user_role'=>$request->role_name, 'description' =>$request->description,]);
                        UserPermissions::where('role_id',$request->role_id)->delete();
                        
                        $this->addUserRoel($request->permission,$request->role_id);
              
                    DB::commit();
        
                    return redirect()->back()->with('success', "User Role Update Successful!");
                }
                catch (\Throwable $e){
                     DB::rollback();
        
                    return response()->json($e->getMessage());
                    return redirect()->back()->with('error', "Something went wrong. Please try again later!");
                }
        
            }


    /*
    |--------------------------------------------------------------------------
    |private function add User Roel
    |--------------------------------------------------------------------------
    */ 

    private function addUserRoel($permission ,$id){
        foreach($permission as $key => $data){  
            $insert_data = array(
                'permission'    => $data,
                'role_id'       => $id,
                
            );
                UserPermissions::create($insert_data);  
        } 

    }


}
