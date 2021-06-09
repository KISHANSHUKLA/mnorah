<?php

namespace App\Http\Controllers;
use App\models\Api\events;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class feedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         if (Gate::allows('users_manage')) {
                $feeds = events::with('user')->get();
            }
        
        return view('admin.feeds.index', compact('feeds'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(events $events)
    {    
       try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $events->delete();
            toastr()->success('Data has been deleted successfully!', 'Church Managemant');
          }
          
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       

        return redirect()->back();
    
    }

    public function medically($Id){

        try {
          if (! Gate::allows('users_manage')) {
              return abort(401);
          }
          $appUsermedicallyverified = events::find($Id);
          
          if($appUsermedicallyverified->medicallyverified == 1){
            $appUsermedicallyverified->medicallyverified =  0;   
          }else{
            $appUsermedicallyverified->medicallyverified =  1;
          
          }
          $appUsermedicallyverified->save();
             
          toastr()->success('Status update successfully!', 'User Managemant');
        }
        
        catch(Exception $e) {
         
          toastr()->error('An error has occurred please try again later.', $e->getMessage());
        }
        
        return redirect()->back();
      } 

      public function community($Id){

        try {
          if (! Gate::allows('users_manage')) {
              return abort(401);
          }
          $appUsercommunityverified = events::find($Id);
          
          if($appUsercommunityverified->communityverified == 1){
            $appUsercommunityverified->communityverified =  0;   
          }else{
            $appUsercommunityverified->communityverified =  1;
          
          }
          $appUsercommunityverified->save();
             
          toastr()->success('Status update successfully!', 'User Managemant');
        }
        
        catch(Exception $e) {
         
          toastr()->error('An error has occurred please try again later.', $e->getMessage());
        }
        
        return redirect()->back();
          } 

}
