<?php

namespace App\Http\Controllers\Admin;

use App\Appuser;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
           
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
    
            $users = User::where('id','!=',Auth::id())
            ->where('flag','web')
            ->get();
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }

      
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {

        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $user = User::create($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->assignRole($roles);
            toastr()->success('Data has been saved successfully!', 'User Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }

       
        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, User $user)
    {

        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
    
            $user->update($request->all());
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);
            toastr()->success('Data has been updated successfully!', 'User Managemant');
          }
          
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
    
            $user->delete();
    
            toastr()->success('Data has been deleted successfully!', 'User Managemant');
          }
          
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
      
        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    public function appUser(){

        try {
           
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
    
            $users = User::
            with('appuser')
           ->where('id','!=',Auth::id())
            ->where('flag','!=','web')
            ->get();
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {

            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }

      
        
        return view('admin.users.appindex', compact('users'));

    }

    public function leadership($Id){

        try {
          if (! Gate::allows('users_manage')) {
              return abort(401);
          }
          $appUserLeadership= Appuser::find($Id);
          
          if($appUserLeadership->Leadershipteam == 1){
            $appUserLeadership->Leadershipteam =  0;   
          }else{
            $appUserLeadership->Leadershipteam =  1;
          
          }
          $appUserLeadership->save();
             
          toastr()->success('Status update successfully!', 'User Managemant');
        }
        
        catch(Exception $e) {
         
          toastr()->error('An error has occurred please try again later.', $e->getMessage());
        }
        
        return redirect()->route('admin.appusers');
      }
      public function medically($Id){

        try {
          if (! Gate::allows('users_manage')) {
              return abort(401);
          }
          $appUsermedicallyverified = Appuser::find($Id);
          
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
        
        return redirect()->route('admin.appusers');
      } 

      public function community($Id){

        try {
          if (! Gate::allows('users_manage')) {
              return abort(401);
          }
          $appUsercommunityverified = Appuser::find($Id);
          
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
        
        return redirect()->route('admin.appusers');
      } 

}
