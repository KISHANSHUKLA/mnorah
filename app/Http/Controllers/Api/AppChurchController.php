<?php

namespace App\Http\Controllers\Api;

use App\Appuser;
use App\Exceptions\API\APIException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppChurchResource;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\UserResource;
use App\models\Church;
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


    public function index()
    {
        try {
            
            if(Auth::check()){

                $churches = Church::paginate(10);
                return $resource = new AppChurchResource($churches);

            }else{
                throw new Exception("Something went wrong!", 404);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
          }
      
        //return UserResource::collection($user);
    }

    public function churchDetail(Request $request){

        try {
            
            if(Auth::check()){
                
                $churches = Church::find($request->id);
                return  new AppChurchResource($churches);

            }else{
                throw new Exception("Something went wrong!", 404);
            }
        }
        //catch exception
          catch(Exception $e) {
              $e->getMessage();
          }
      
    }

    public function getSearch(Request $request) {

        $data = $request->get('data');
        $search_drivers = Church::where('denomination', 'like', "%{$data}%")
                         ->orWhere('venue', 'like', "%{$data}%")
                         ->paginate(10);
                         
        return  $search_drivers  = AppChurchResource::collection($search_drivers);
    }
  
}
