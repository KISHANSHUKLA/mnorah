<?php

namespace App\Http\Controllers\Api;

use App\Appuser;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppUserResource;
use App\models\Api\limit;
use App\User;
use Exception;
use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Console\Input\Input;

class AppuserAuthController extends Controller
{

    use FileUploadTrait;
    public $successStatus = 200;

    public function register(Request $request){

        if (User::where('email', '=', $request->email)->exists()) {
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
        }else{
           
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
                "usertype" => 'app',
                'device_token' => $request->device_token,
            ]);
        }
        $appUser['token'] = $appUser->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'data' => $appUser,     
        ]);
        }
        
    }

    public function updateProfile(Request $request)
    {   
        if (Auth::check()) {

            if (User::where('email', '=', $request->email)->exists()) {
                
                $users = User::find(Auth::user()->id);
                $appUsers1 = Appuser::where('user_id',Auth::user()->id)->first();
                $appUsers = Appuser::find($appUsers1->id);

                $users['name'] = $request->name;
                $users['email'] = $request->email;
                $appUsers['mobile'] = $request->mobile;

            $image = $request->file('image');
           
            $imageEvent = $this->saveImages($image,'profile');
            $appUsers['image'] = $imageEvent['0'];
            
            $users->save();
            $appUsers->save();

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully',
            ]);   

            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'User not found!'
                  ]);
            }
    
            return response()->json([
              'success' => true,
              'message' => 'Logout successfully'
          ]);
          }else {
            return response()->json([
              'success' => false,
              'message' => 'User not found!'
            ]);
          }
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
            if (Auth::check()) {
                $user = Auth::user();
               
                $to_name = $user->name;
                $to_email = $user->email;
                

                $limitcheck = limit::where('user_id',$user->id)->first();

                if($limitcheck == null){
                    $limit = 1;
                      
                limit::create([
                    'user_id' => $user->id,
                    'opt' => $limit,
                    ]);
    
                }else{
                    $limitval = $limitcheck->opt;
                    $limit = $limitval + 1;
    
                    if($limit > 5){
                        return response()->json([
                            'success' => false,
                            'message' => 'You don\'t have resend otp because attachment limit  5 time',
                          ]);
                    }else{
                        $limitSave = limit::find($limitcheck->id);
                        $limitSave->opt =  $limit;
                        $limitSave->save();
                    }
    
                    
                }

                $six_digit_random_number = mt_rand(1000, 9999);
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

        $user = User::where('email',$request->email)->first();

        if($user == null){
            return response()->json([
            'success' =>false,
            'message' => 'Something went wrong',
          ]);
        }else{

            $limitcheck = limit::where('user_id',$user->id)->first();

            if($limitcheck == null){
                $limit = 1;
                  
            limit::create([
                'user_id' => $user->id,
                'forgot_password' => $limit,
                ]);

            }else{
                $limitval = $limitcheck->forgot_password;
                $limit = $limitval + 1;

                if($limit > 5){
                    return response()->json([
                        'success' => false,
                        'message' => 'You don\'t have forgot password because attachment limit  5 time
                        ',
                      ]);
                }else{
                    $limitSave = limit::find($limitcheck->id);
                    $limitSave->forgot_password =  $limit;
                    $limitSave->save();
                }

                
            }
          
            Password::sendResetLink($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Reset password link sent on your email id.',
          ]);
        }
        
    }

    public function social(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'id' => 'required'
        ]);

        $validatedData['password'] = '';
        $validatedData['flag'] = $request->usertype;
        $appUser = User::create($validatedData);
        if($appUser){
           $appUserData =  Appuser::create([
                "user_id" => $appUser->id,
                "json" => json_encode($validatedData),
                "usertype" => $request->login_type,
                'device_token' => $request->device_token,
            ]);
        }

        $appUser['login_type'] = $appUserData->usertype;
        $appUser['token'] = $appUser->createToken('authToken')->accessToken;

        return response()->json([
            'success' => true,
            'data' => $appUser,     
        ]);
      
    }    


    public function getuser(){

        try {
            
            if(Auth::check()){
                
                $user = Appuser::where('user_id',Auth::user()->id)->first();
                return new AppUserResource($user);

            }else{
                throw new Exception("Something went wrong!", 404);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
          }
    }

}
