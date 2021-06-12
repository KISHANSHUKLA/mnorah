<?php

namespace App\Http\Controllers\Api;

use App\models\Api\inviteCodeRequest;
use App\Appuser;
use App\Exceptions\API\APIException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppChurchResource;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\RequestResource;
use App\Http\Resources\UserResource;
use App\models\Church;
use App\models\Invitecode;
use Error;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AppChurchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use FileUploadTrait;

    public function index()
    {   
        try {
            
            if(Auth::check()){
                $start = $_GET['start'];
                $limit = $_GET['limit'];
        
                $churches = Church::
                offset($start)
                ->limit($limit)
                ->get();

                return response()->json([
                    'success' => true,
                     'data' => AppChurchResource::collection($churches)
                  ]);
                
            }else{
                throw new Exception("Something went wrong!", 404);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
              return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
              ]);
          }
      
        //return UserResource::collection($user);
    }

    public function churchDetail(Request $request){

        try {
            
            if(Auth::check()){
                
                $churches = Church::find($request->id);

                return response()->json([
                    'success' => true,
                     'data' => new AppChurchResource($churches)
                  ]);
                


            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong!',
                  ]);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
          }
      
    }

    public function getSearch(Request $request) {


        try {
            
            if(Auth::check()){
                
                $data = $request->get('data');
                $start = $_GET['start'];
                $limit = $_GET['limit'];
        
                $search_drivers = Church::where('name', 'like', "%{$data}%")
                                 ->offset($start)
                                 ->limit($limit)
                                 ->get();
                
                if(count($search_drivers) != 0){
                return response()->json([
                    'success' => true,
                     'data' => AppChurchResource::collection($search_drivers)
                  ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Recode not found!',
                      ]);
                }

            }else{
                throw new Exception("Something went wrong!", 404);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
              return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
              ]);
          }

    }

    public function invitecode(Request $request){


        try {
            
            if(Auth::check()){
                
                $church_id = $request->get('church_id');
                $user_id = Auth::user()->id;

                $requestData = inviteCodeRequest::create([
                    "user_id" => $user_id,
                    "church_id" => $church_id,
                    "status" => 0,
                ]);
                
                    return response()->json([
                        'success' => true,
                        'message' => 'Invite code request send Successfully',
                      ]);
                }

            }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
              return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
              ]);
          }

       }
       public function invitecodecheck(Request $request){


        try {
            
            if(Auth::check()){
                
                $church_id = $request->get('church_id');
                $user_id = Auth::user()->id;
                $invitecode =$request->get('invitecode');
                $a =  Invitecode::where('invitecode',$invitecode)->first();
                
                $recode = inviteCodeRequest::with('user','church','invitecodedata')
                ->where('user_id',$user_id)
                ->where('church_id',$church_id)
                ->where('invitecode',$a->id)->first();

                if($recode){
                    return response()->json([
                        'success' => true,
                        'data' => new RequestResource($recode)
                      ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'data' => 'Recode not found!'
                      ]);
                }
                    
                }

            }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
              return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
              ]);
          }

       }
  
}
