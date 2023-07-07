<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('login', function () {
//     return view('login');
// }
// );



Route::group([
  'namespace'=>'App\Http\Controllers',

  ],function ($router) {

    Route::get ('/login'                            , 'ViewController@login')->name('login');

    Route::post ('/login-submit'                    , 'AuthController@doLogin')->name('login-submit');

    Route::get ('/log-out'                          , 'AuthController@logOut')->name('log-out');

    Route::get ('/run-daily-rewards-calculation'    , 'ActionController@calculateDailyRewards')->name('daily-rewards-cal');

    // Route::get ('/run-daily-rewards-one-day'     , 'ActionController@updateDailyRewards')->name('daily-rewards-day');

});

Route::group([
  'middleware' => ['authaction','check_permissions'],
  'namespace'=>'App\Http\Controllers',

],function ($router) {

  Route::get ('/'                                 , 'ViewController@dashbord')->name('dashbord');

  Route::get ('/pending-purchases'                , 'ViewController@pendingpurchases')->name('pending-purchases');

  Route::get ('/pending-purchases/{status}'       , 'ViewController@pendingpurchases')->name('pending-purchases-status');

  Route::get ('/pending-kyc'                      , 'ViewController@pendingkyc')->name('pending-kyc');

  Route::get ('/pending-kyc/{status}'             , 'ViewController@pendingkyc')->name('pending-kyc-status');

  Route::get ('/pending-withdraw'                 , 'ViewController@pendingwithdraw')->name('pending-withdraw');
  
  Route::get ('/pending-withdraw/{status}'        , 'ViewController@pendingwithdraw')->name('pending-withdraw-status');

  Route::get ('/edit-client/{id}'                 , 'ViewController@editClient')->name('edit-client');

  Route::get ('/user-create'                      , 'ViewController@userCreate')->name('user-create');

  Route::get ('/user-edit/{id}'                   , 'ViewController@userEdit')->name('user-edit');

  Route::get ('/user-list'                        , 'ViewController@userList')->name('user-list');

  Route::get ('/client-list'                      , 'ViewController@clientList')->name('client-list');

  Route::get('/client-summary/{id}'               ,'ViewController@clientSummary')->name('client-summary');

  Route::get('/crypto-network'                    ,'ViewController@cryptoNetwork')->name('crypto-network');

  Route::get('/currency-type'                     ,'ViewController@currencyType')->name('currency-type');

  Route::get('/transaction-settings'              ,'ViewController@transactionSettings')->name('transaction-settings');

  Route::get ('/user-role-create'                 ,'ViewController@userRoles')->name('user-role-create');

  Route::get ('/user-role-list'                   ,'ViewController@userRoleList')->name('user-role-list');

  Route::get ('/user-role-edit/{id}'              ,'ViewController@userRoleEdit')->name('user-role-edit');

  Route::get ('/client-report'                    ,'ViewController@ClientReport')->name('client-report');

  Route::get ('/p2p-transfer-list'                ,'ViewController@p2pTransfer')->name('p2p-transfer-list');
    
  Route::get ('/liability-report'                ,'ViewController@liabilityReport')->name('liability-report');

  Route::get ('/liability-report-client-wise'    ,'ViewController@liabilityReportClientWise')->name('liability-report-client-wise');
     

}); 


Route::group([
  'middleware' => 'authaction',
  'namespace'=>'App\Http\Controllers',

  ],function ($router) {

  /*-----------------------------------------------------------------------------------------------
  Action Controller
  ------------------------------------------------------------------------------------------------*/ 
  Route::post ('/action/withdraw-disapprove'      , 'ActionController@withdrawDisapprove');

  Route::post ('/action/purchases-disapprove'     , 'ActionController@purchasesDisapprove');

  Route::post ('/action/kyc-disapprove'           , 'ActionController@kycDisapprove');

  Route::post ('/action/kyc-approve'              , 'ActionController@approvePendingKyc');

  Route::post ('/action/withdrawal-approve'       , 'ActionController@approveWithdrawal');

  Route::post ('/action/client-edit'              , 'ActionController@clientEdit');

  Route::get ('/calculate-wallets/{id}'           , 'ActionController@calculateClientWallets')->name('calc-wallets');

  Route::get ('/calculate-all-wallets'            , 'ActionController@calcAllClientWallets')->name('calc-all-wallets');

  Route::post ('/action/user-create'              , 'ActionController@userCreateForm');

  Route::post ('/action/user-edit'                , 'ActionController@userEditForm');

  Route::post ('/action/currency-type-create'     , 'ActionController@currencyTypeCreate');

  Route::post ('/action/currency-type-edit'       , 'ActionController@currencyTypeEdit');

  Route::post ('/action/crypto-network-create'    , 'ActionController@cryptoNetworkCreate');

  Route::post ('/action/crypto-network-edit'      , 'ActionController@cryptoNetworkEdit');

  Route::post ('/action/transaction-setting-edit' , 'ActionController@transactionSettings');

  Route::post ('/action/create-user-role'         , 'ActionController@createUserRole');

  Route::post ('/action/edit-user-role'           , 'ActionController@editUserRole');


  /*-----------------------------------------------------------------------------------------------
  Ajax Controller
  ------------------------------------------------------------------------------------------------*/ 

  Route::post ('/action/approve-funding'          , 'AjaxController@approveFunding');

  Route::get ('/run-bv-for-funding-payment/{id}'  , 'AjaxController@bvRewardsFundingPayment')->name('funding-payment-bv');

  Route::post ('/get/kyc-pending'                 , 'AjaxController@kycPending');

  Route::get ('/ajax/email-client-edit'           , 'AjaxController@getEmailByClient');

  Route::GET('/ajax/dashbord-counts'              , 'AjaxController@getDashbordCounts');

  Route::post('/ajax/pending-purchases'           , 'AjaxController@pendingPerchasess'); 

  Route::post('/ajax/pending-kyc'                 , 'AjaxController@pendingKyc'); 

  Route::post('/ajax/pending-withdrawls'          , 'AjaxController@pendingWithdrawls'); 

  Route::post('/ajax/p2p-trasfer'                 , 'AjaxController@p2pTrasfer'); 

  Route::post('/ajax/client-list'                 , 'AjaxController@clientList'); 

  Route::post('/ajax/client-list'                 , 'AjaxController@clientList'); 

  Route::post('/ajax/liability-report-data'       , 'AjaxController@getLiabilityReportData'); 

  Route::post('/ajax/liability-report-data-client-wise'       , 'AjaxController@getLiabilityReportDataClientWise'); 

  Route::post('/ajax/upload-kyc-crop-images'                  , 'AjaxController@uploadKycCropImages'); 





 


  


  

  

});

