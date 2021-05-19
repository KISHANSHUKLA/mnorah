<?php

namespace App\Http\Controllers\Api;

use App\models\Api\followers;
use App\Http\Controllers\Controller;
use App\Http\Resources\FollowlistResource;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class followersController extends Controller
{
   
   
    public function followUser(Request $request){
   
    DB::beginTransaction();
    try {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            if(! $user) {
                DB::rollback();
                $status = false;
                $message = 'User does not exist.';
        }
        
        $user->followers()->attach($request->church_id);
        DB::commit();

        $status = true;
        $message = 'Successfully followed the church';
        }
    }
    catch(Exception $e) {
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

public function unFollowUser(Request $request)
{
   
    DB::beginTransaction();
    try {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            if(! $user) {
                DB::rollback();
                $status = false;
                $message = 'User does not exist.';
        }
        
        $user->followers()->detach($request->church_id);
        DB::commit();

        $status = true;
        $message = 'Successfully unfollowed the church';
        }
    }
    catch(Exception $e) {
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

    public function followlist(){
    
        DB::beginTransaction();
    try {
        if (Auth::check()) {

            $start = $_GET['start'];
            $limit = $_GET['limit'];

            $user = User::find(Auth::user()->id);
            if(! $user) {
                DB::rollback();
                $status = false;
                $message = 'User does not exist.';
        }
        
        $followList = followers::
        where('follower_id',$user->id)
        ->offset($start)
        ->limit($limit)
        ->get();
            return response()->json([
                'success' => true,
                 'data' => FollowlistResource::collection($followList),
              ]);
            DB::commit();
        }
    }
    catch(Exception $e) {
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
}
