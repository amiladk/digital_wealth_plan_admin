<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Throwable;
use Validator;

use App\Models\User;
use DB;
use Auth;

class AuthController extends Controller
{
    public function doLogin(Request $request){
        
        try {

            $validation_array = [
                'email' => 'required',
                'password' => 'required',
            ];

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // return response()->json($request);
                return redirect('/')->with('success','You have Successfully loggedin');
            }
            // else{
            //     // return response()->json('no');
            // }

            return redirect("login")->with('error','Oppes! You have entered invalid credentials');
            
        } 
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }

    public function logOut(){

        Auth::logout(); 
        
        return redirect()->route('login'); 
    }

}