<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\models\Invitecode;
use Exception;
use App\Imports\BulkImport;
use App\models\Church;
use Spatie\SimpleExcel\SimpleExcelReader;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXLSX;

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
          if(Gate::allows('church_manage')) {
            $invitecodes = Invitecode::with('church','user')
            ->where('user_id',Auth::user()->id)
            ->get();
            }elseif (Gate::allows('users_manage')) {
              $invitecodes = Invitecode::with('church','user')->get();
            }
            
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
          if(Gate::allows('church_manage')) {
            $churchs = Church::
            where('user_id',Auth::user()->id)
            ->get();
            }elseif (Gate::allows('users_manage')) {
              $churchs = Church::get();
            }
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
      
        return view('admin.invitecode.create',compact('churchs'));
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
            
            Invitecode::create([
            'invitecode' => $request->invitecode,
            'church_id' => $request->church_id,
            'user_id' => $request->user_id,
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
      if(Gate::allows('church_manage')) {
        $churchs = Church::
        where('user_id',Auth::user()->id)
        ->get();
        }elseif (Gate::allows('users_manage')) {
          $churchs = Church::get();
        }
        return view('admin.invitecode.edit', compact('invitecode','churchs'));
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
            // if (! Gate::allows('users_manage') ) {
            //     return abort(401);
            // }
         
            $churchInviteCode = Invitecode::find($invitecode->id);
            $churchInviteCode->invitecode =  $request->get('invitecode');
            $churchInviteCode->church_id =  $request->get('church_id');
            $churchInviteCode->user_id =  $request->get('user_id');
            $churchInviteCode->save();
            toastr()->success('Data has been updated successfully!', 'Church Invite Code Managemant');
          }
          catch(Exception $e) {
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
            // if (! Gate::allows('users_manage')) {
            //     return abort(401);
            // }
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
        // if (! Gate::allows('users_manage')) {
        //     return abort(401);
        // }
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
        if (Gate::allows('users_manage')) {
           
        if ( $xlsx = SimpleXLSX::parse($request->file('import')) ) {
          $i = 0;
          foreach ($xlsx->rows(0) as $index => $rows) {

            if($i != $index){
              
            $churchs = Church::where('name',$rows['1'])->first();
            
            if($churchs){
              Invitecode::create([
                'invitecode' => $rows['0'],
                'church_id' => $churchs->id,
                'user_id' => Auth::user()->id,
                'global' => $rows['2'],
                ]);

            }
          }

        }

        } else {
          echo SimpleXLSX::parseError();
        }

        }elseif (Gate::allows('church_manage')) {

          if ( $xlsx = SimpleXLSX::parse($request->file('import')) ) {
            $i = 0;
            foreach ($xlsx->rows(0) as $index => $rows) {
  
              if($i != $index){
                
              $churchs = Church::where('name',$rows['1'])
              ->where('user_id',Auth::user()->id)
              ->first();
              
              if($churchs){
                Invitecode::create([
                  'invitecode' => $rows['0'],
                  'church_id' => $churchs->id,
                  'user_id' => Auth::user()->id,
                  'global' => $rows['2'],
                  ]);
  
              }
            }
  
          }
  
          } else {
            echo SimpleXLSX::parseError();
          }
          }

      // Excel::import(new BulkImport,$request->file('import'));
           
        toastr()->success('Data has been Saved successfully!', 'Church Managemant');
      }
      
      catch(Exception $e) {
        dd($e->getMessage());
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

        if($churchInviteCode->global == 1){
          $churchInviteCode->global =  false;   
        }else{
          $churchInviteCode->global =  true;
        
        }
        $churchInviteCode->save();
           
        toastr()->success('Status update successfully!', 'Church Invite Code Managemant');
      }
      
      catch(Exception $e) {
       
        toastr()->error('An error has occurred please try again later.', $e->getMessage());
      }
    
      return redirect()->route('admin.invitecode.index');
    }
    
}
