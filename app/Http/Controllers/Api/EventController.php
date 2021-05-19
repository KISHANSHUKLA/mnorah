<?php

namespace App\Http\Controllers\Api;

use App\Appuser;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppUserResource;
use App\Http\Resources\EventlistResource;
use App\models\Api\events as ApiEvents;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\User;
use App\models\Api\events;
use App\models\Api\likes;
use App\models\Api\comments;
use App\models\Api\witness;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    
    use FileUploadTrait;
    public function index(){

        DB::beginTransaction();
        try {
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                $start = $_GET['start'];
                $limit = $_GET['limit'];
        
                if(! $user) {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'User does not exist.'
                    ]);
            }
                $events = events::where('status',1)
                ->offset($start)
                ->limit($limit)
                ->get();
                
                DB::commit();
                return response()->json([
                    'success' => true,
                    'data' => EventlistResource::collection($events),
                ]);
            }
        }
        catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong'
            ]);
        }
      
    }

    public function addEvent(Request $request){

        DB::beginTransaction();
        try {
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                if(! $user) {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'User does not exist.'
                    ]);
            }

            $validation = $request->validate([
                'message' => 'required',
                'image' => 'required'
            ]);

            $validation['user_id'] = Auth::user()->id;

            $image = $request->file('image');
            $imageEvent = $this->saveImages($image,'eventimage');
            $validation['image'] = $imageEvent['0'];

            $appUser = events::create($validation);
            
            DB::commit();
            return response()->json([
                    'success' => true,
                    'data' => $appUser,
                ]);
            }
        }
        catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong', //Something went wrong
            ]);
        }
      
    }

    public function eventDelete(Request $request){

        DB::beginTransaction();
        try {
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                if(! $user) {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'User does not exist.'
                    ]);
            }
           $a = events::where('user_id',$user->id)->first();
            if( $a->user_id  == $user->id){

                events::deleted($request->id);
                DB::commit();
                return response()->json([
                        'success' => true,
                        'message' => 'successfully event deleted',
                    ]);
                }else{
                   
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong', //Something went wrong
                    ]);
                }
            }

           
        
         }
         catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), //Something went wrong
            ]);
        }
        }


        public function eventLike(Request $request){

            DB::beginTransaction();
            try {
                if (Auth::check()) {
                    $value['user_id'] = Auth::user()->id;
                    $value['event_id'] = $request->event_id;
                    $value['status'] = $request->status;
                    if(! Auth::user()->id) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'User does not exist.'
                        ]);
                    }
                    
                    likes::create($value);
                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Event like successfully'
                    ]);
                    
               }
            }
            catch(Exception $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(), //Something went wrong
                ]);
            }
        }

        public function eventComment(Request $request){

            DB::beginTransaction();
            try {
                if (Auth::check()) {
                    $value['user_id'] = Auth::user()->id;
                    $value['event_id'] = $request->event_id;
                    $value['comment'] = $request->comment;
                    if(! Auth::user()->id) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'User does not exist.'
                        ]);
                    }
                    
                    comments::create($value);
                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Event comment successfully'
                    ]);
                    
               }
            }
            catch(Exception $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(), //Something went wrong
                ]);
            }
        }

        public function eventWitness(Request $request){

            DB::beginTransaction();
            try {
                if (Auth::check()) {
                    $value['user_id'] = Auth::user()->id;
                    $value['event_id'] = $request->event_id;
                    $value['status'] = $request->status;
                    if(! Auth::user()->id) {
                        DB::rollback();
                        return response()->json([
                            'success' => false,
                            'message' => 'User does not exist.'
                        ]);
                    }
                    
                    witness::create($value);
                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Event witness successfully'
                    ]);
                    
               }
            }
            catch(Exception $e) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(), //Something went wrong
                ]);
            }
        }
    }

