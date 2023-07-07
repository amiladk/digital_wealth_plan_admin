<?php 

use App\Models\User;
use App\Models\UserPermissions;


if (!function_exists('isPermissions')) {
    function isPermissions($permission){
        $UserPermissions = UserPermissions::where('role_id',Auth::user()->user_role,)->where('permission',$permission)->count();
        if($UserPermissions == 1){
            return true;    
        }
            return false;
    }
}

if (!function_exists('getAllPermissions')) {
    function getAllPermissions(){
        return array(
 

            [
                'group'=>'Dashboard',
                'icon'=>'fas fa-home',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'dashbord','permission'=>'dashbord','show_in_sidebar'=>true],
                )
            ],
            [
                'group'=>'Purchases',
                'icon'=>'far fa-clock',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Purchases','permission'=>'pending-purchases','show_in_sidebar'=>true],
                    ['title' => 'Viwe Purchases By Status','permission'=>'pending-purchases-status','show_in_sidebar'=>false], 
                )
            ],
            
            [
                'group'=>'KYCs',
                'icon'=>'fas fa-user-tie',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'kycs','permission'=>'pending-kyc','show_in_sidebar'=>true],
                    ['title' => 'Viwe kyc By Status','permission'=>'pending-kyc-status','show_in_sidebar'=>true], 
                )
            ],
            [
                'group'=>'Withdrawls',
                'icon'=>'fas fa-dollar-sign',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Withdrawls','permission'=>'pending-withdraw','show_in_sidebar'=>true],
                    ['title' => 'Viwe Withdraw Status','permission'=>'pending-withdraw-status','show_in_sidebar'=>true],
                )
            ],
            [
                'group'=>'P2P Tranfer',
                'icon'=>'fas fa-comments-dollar',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'P2P Treanfer','permission'=>'p2p-transfer-list','show_in_sidebar'=>true],
                   
                )
            ],
            [
                'group'=>'Client List',
                'icon'=>'fas fa-users',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Client List','permission'=>'client-list','show_in_sidebar'=>true],
                    ['title' => 'Edit client','permission'=>'edit-client','show_in_sidebar'=>false],
                    ['title' => 'Client Summary','permission'=>'client-summary','show_in_sidebar'=>false],   
                )
            ],
            [
                'group'=>'Reports',
                'icon' =>'fas fa-file-alt',
                'type' =>'multiple',
                'data' =>array(
                    ['title' => 'Client Report','permission'=>'client-report','show_in_sidebar'=>true],
                    ['title' => 'Funding Wise Liability Report','permission'=>'liability-report','show_in_sidebar'=>true],
                    ['title' => 'Client Wise Liability Report','permission'=>'liability-report-client-wise','show_in_sidebar'=>true],
                )
            ],
            [
                'group'=>'Currency Type',
                'icon'=>'fas fa-comments-dollar',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Currency Type','permission'=>'currency-type','show_in_sidebar'=>true],
                    
                )
            ],
            [
                'group'=>'Crypto Network',
                'icon'=>'fas fa-network-wired',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Crypto Network','permission'=>'crypto-network','show_in_sidebar'=>true],
                    
                )
            ],
            [
                'group'=>'Transaction Settings',
                'icon'=>'far fa-share-square',
                'type'=>'single',
                'data'=>array(
                    ['title' => 'Transaction -Settings','permission'=>'transaction-settings','show_in_sidebar'=>true],
                    
                )
            ],
            [
                'group'=>'Admin Acounts',
                'icon' =>'fas fa-user',
                'type' =>'multiple',
                'data' =>array(
                    ['title' => 'User Edit','permission'=>'user-edit','show_in_sidebar'=>false],
                    ['title' => 'User List','permission'=>'user-list','show_in_sidebar'=>true],
                    ['title' => 'User Create','permission'=>'user-create','show_in_sidebar'=>true],
                    ['title' => 'User Role Create','permission'=>'user-role-create','show_in_sidebar'=>true],
                    ['title' => 'User Role List','permission'=>'user-role-list','show_in_sidebar'=>true],
                    ['title' => 'User Role Edit','permission'=>'user-role-edit','show_in_sidebar'=>false],
                )
            ],
        );
    }
}
// if (!function_exists('permission_check')) { user-role-edit
//     function permission_check($value=''){
//         if(!isPermissions($value)){
//             //return redirect()->route('dashboard')->with('error', 'Venue Edit updated successfully!');
//             return redirect('/');
//         exit;
//         }else{
//             return true;
//         }
            
        
//     }
// }
