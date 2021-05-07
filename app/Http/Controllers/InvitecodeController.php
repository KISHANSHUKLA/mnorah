<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\models\Invitecode;
use Exception;
use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class InvitecodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $invitecodes = Invitecode::
            where('global',NULL)
            ->get();
            
           // toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        return view('admin.invitecode.index', compact('invitecodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
      
        return view('admin.invitecode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            Invitecode::create([
            'invitecode' => $request->invitecode,
            ]);
          
            toastr()->success('Data has been saved successfully!', 'Church Invite Code Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
          
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        
        return redirect()->route('admin.invitecode.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Invitecode  $invitecode
     * @return \Illuminate\Http\Response
     */
    public function show(Invitecode $invitecode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Invitecode  $invitecode
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitecode $invitecode)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        return view('admin.invitecode.edit', compact('invitecode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Invitecode  $invitecode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitecode $invitecode)
    {
        try {
            if (! Gate::allows('users_manage') ) {
                return abort(401);
            }
         
            $churchInviteCode = Invitecode::find($invitecode->id);
            $churchInviteCode->invitecode =  $request->get('invitecode');
            $churchInviteCode->save();
            toastr()->success('Data has been updated successfully!', 'Church Invite Code Managemant');
          }
          catch(Exception $e) {
            dd($e->getMessage());
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        return redirect()->route('admin.invitecode.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Invitecode  $invitecode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitecode $invitecode)
    {
        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $invitecode->delete();
            toastr()->success('Data has been deleted successfully!', 'Church Invite Code Managemant');
          }
          
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       

        return redirect()->route('admin.invitecode.index');
    }

    public function importcode(){
     
      try {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //toastr()->success('Data has been saved successfully!', 'Church Managemant');
      }
      
      //catch exception
      catch(Exception $e) {
        toastr()->error('An error has occurred please try again later.', $e->getMessage());
      }
  
    return view('admin.invitecode.import');
    }

    public function import(Request $request){

      try {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
       Excel::import(new BulkImport,$request->file('import'));
           
        toastr()->success('Data has been Saved successfully!', 'Church Managemant');
      }
      
      catch(Exception $e) {
       
        toastr()->error('An error has occurred please try again later.', $e->getMessage());
      }
    
      return redirect()->route('admin.invitecode.index');
    }

    public function codestatus($Id){
      try {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $churchInviteCode = Invitecode::find($Id);
        $churchInviteCode->global =  true;
        $churchInviteCode->save();
           
        toastr()->success('Status update successfully!', 'Church Invite Code Managemant');
      }
      
      catch(Exception $e) {
       
        toastr()->error('An error has occurred please try again later.', $e->getMessage());
      }
    
      return redirect()->route('admin.invitecode.index');
    }
    
}
