<?php

namespace App\Http\Controllers\Api;

use App\Appuser;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\TryCatch;

class AppuserAuthController extends Controller
{
    public $successStatus = 200;

    public function register(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['flag'] = $request->usertype;
        $appUser = User::create($validatedData);
        if($appUser){
            Appuser::create([
                "user_id" => $appUser->id,
                "json" => json_encode($validatedData),
                "usertype" => $request->usertype,
                'device_token' => $request->device_token,
            ]);
        }
        $appUser['token'] = $appUser->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'data' => $appUser,     
        ]);
      
    }

    public function login(Request $request){

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($loginData)) {
            return response([
                'success' => false,
                'message' => 'Invalid Credentials']);
        }
        if(!auth()->user()->flag ==  'web' ){
            return response([
                'success' => false,
                'message' => 'Invalid Credentials']);
        }
        $user = Auth::user();
         $user['token'] = $user->createToken('appToken')->accessToken;
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Login successfully',
            
        ]);
       
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();
    
            return response()->json([
              'success' => true,
              'message' => 'Logout successfully'
          ]);
          }else {
            return response()->json([
              'success' => false,
              'message' => 'Unable to Logout'
            ]);
          }
     }

     public function emailVerification(){
        
        DB::beginTransaction();
        try {
            if (Auth::user()) {
                $user = Auth::user();
               
                $to_name = $user->name;
                $to_email = $user->email;
    
                $six_digit_random_number = mt_rand(100000, 999999);
                $data = array('name'=>$to_name, "body" => $six_digit_random_number);
                Mail::send('email.verify', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Email Verification');
                $message->from('kishanjshukla93@gmail.com','Verification Code');
                });

                $appUserId = Appuser::where('user_id',$user->id)->first();
                $Appuser = Appuser::find($appUserId->id);
                $Appuser->verifycode =  $six_digit_random_number;
                $Appuser->save();

                DB::commit();
                $status = true;
                $message = 'Email send successfully'; 
    
            }else{
               
                    DB::rollback();
                $status = false;
                $message = 'Something went wrong'; 
                
            }
          }catch(Exception $e) {
                DB::rollback();
              $status = false;
              $message = 'Something went wrong';
            echo 'Message: ' .$e->getMessage();
          }

          return response()->json([
            'success' => $status,
            'message' => $message,
          ]);

    
     }

     public function verifyEmail(Request $request){
        DB::beginTransaction();
        try {
            if (Auth::user()) {
                $user = Auth::user();
               
                $appUserId = Appuser::where('user_id',$user->id)->first();

                if($appUserId->verifycode == $request->code){
                    $Appuser = Appuser::find($appUserId->id);
                    $Appuser->verifycode =  NULL;
                    $Appuser->save();

                    $status = true;
                    $message = 'email verification successfully'; 
                    DB::commit();
               
                }else{
                    $status = false;
                    $message = 'email verification fail'; 
                }
                
            }else{
            DB::rollback();
            $status = false;
            $message = 'Something went wrong'; 
            }

            
        }catch(Exception $e){
            DB::rollback();
            $status = false;
            $message = 'Something went wrong';
          echo 'Message: ' .$e->getMessage();
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
          ]);

     }


     public function forgot(Request $request) {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Reset password link sent on your email id.',
          ]);
    }

}
