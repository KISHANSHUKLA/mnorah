<?php

namespace App\Http\Controllers;

use App\models\Api\inviteCodeRequest;
use Illuminate\Support\Facades\Gate;
use App\models\Invitecode;
use Exception;
use App\Imports\BulkImport;
use App\models\Church;
use App\User;
use Spatie\SimpleExcel\SimpleExcelReader;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function requestlist()
    {
        try {
         
            if (Gate::allows('users_manage')) {
              $invitecodes = inviteCodeRequest::with('church','user','invitecodedata')
              ->get();
            }
            
            // toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        return view('admin.invitecode.indexrequest', compact('invitecodes'));
    }

    public function requestlistEdit($id)
    {
  
      if (Gate::allows('users_manage')) {
          $invitecodeRequest = inviteCodeRequest::where('id',$id)->first();
          $invitecodeArrays = inviteCodeRequest::get();
          $arrayData = array();
          foreach($invitecodeArrays as $invitecodeArray){

              $checkChurch = Invitecode::where('id',$invitecodeArray->invitecode)
              ->where('global',"true")
              ->first();
             
              if($checkChurch == null){
              array_push($arrayData,$invitecodeArray->invitecode);
              }
            }
          
          $tags = implode(', ', $arrayData);
          $myArray = explode(',', $tags);
          
          $getInviteCodes = Invitecode::where('church_id',$invitecodeRequest->church_id)
          ->whereNotIn('id',$myArray)
          ->get();
        }
        return view('admin.invitecode.editrequest', compact('getInviteCodes','invitecodeRequest'));
    }

    public function requestlistupdate(Request $request, $id)
    {   
      
        try {
            if (Gate::allows('users_manage') ) {

              $churchInviteCode = inviteCodeRequest::find($id);
              $user = User::find($churchInviteCode->user_id);
              $to_name = $user->name;
              $to_email = $user->email;
              if($request->get('status') == 1){

                $data = array('name'=>$to_name, "body" => 'Your request is rejected. Please contact administrator');
                Mail::send('email.reject', $data, function($message) use ($to_name, $to_email) {
                  $message->to($to_email, $to_name)->subject('Request Rejected');
                  $message->from('kishanjshukla93@gmail.com','Request Rejected');
                  });

                  $churchInviteCode->status =  $request->get('status');
                  $churchInviteCode->invitecode =  NULL;
                  $churchInviteCode->save();
                  
                  toastr()->error('Request rejected successfully!', 'Church Invite Code Managemant');
                  return redirect()->route('admin.requestlist');

              }else{

                $invitecodeFind = Invitecode::find($request->get('invitecode'));
                $data = array('name'=>$to_name, "body" => 'Your request is approved. Your invite code is : '.$invitecodeFind->invitecode.'');
                Mail::send('email.reject', $data, function($message) use ($to_name, $to_email) {
                  $message->to($to_email, $to_name)->subject('Request Rejected');
                  $message->from('kishanjshukla93@gmail.com','Request Rejected');
                  });  

              $churchInviteCode = inviteCodeRequest::find($id);
              $churchInviteCode->invitecode =  $request->get('invitecode');
              $churchInviteCode->status =  $request->get('status');

              $churchInviteCode->save();
              toastr()->success('Data has been updated successfully!', 'Church Invite Code Managemant');
              }
            }
         
            
          }
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        return redirect()->route('admin.requestlist');
    }
    
}
