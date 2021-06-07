<?php

namespace App\Http\Controllers;

use App\models\Church;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreChurchRequest;
use App\Http\Requests\Admin\UpdateChurchRequest;
use Exception;
use App\Http\Controllers\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use PhpParser\Node\Stmt\TryCatch;

class ChurchController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      
        try {

          if(Gate::allows('church_manage')) {
            $churches = Church::with('user')
            ->where('user_id',Auth::user()->id)
            ->get();
            }elseif (Gate::allows('users_manage')) {
            $churches = Church::with('user')
            ->get();
            }
            
           // toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
          return view('admin.churchs.index', compact('churches'));
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
            $users = User::where('id',Auth::id())->get();
            $days = [
              'Monday',
              'Tuesday',
              'Wednesday',
              'Thursday',
              'Friday',
              'Saturday',
              'Sunday',
            ];
            }
          elseif (Gate::allows('users_manage')) {
            $users = User::where('id','!=',Auth::id())->get();
            $days = [
              'Monday',
              'Tuesday',
              'Wednesday',
              'Thursday',
              'Friday',
              'Saturday',
              'Sunday',
            ];
            }

          
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
      
        return view('admin.churchs.create', compact('users','days'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChurchRequest $request)
    {   
        try {
            // if (! Gate::allows('users_manage')) {
            //     return abort(401);
            // }
            $image = $request->file('eventimage');
            
            $imageEvent = $this->saveImages($image,'event');
            Church::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'location' => $request->location,
            'denomination' => $request->denomination,
            'venue' => $request->venue,
            'days' => json_encode($request->days),
            'language' => $request->language,
            'Social' => $request->Social,
            'vision' => $request->vision,
            'leadership' => $request->leadership,
            'ministries' => $request->ministries,
            'event' => $request->event,
            'eventimage' => json_encode($imageEvent),
            ]);
          
            toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        
        return redirect()->route('admin.churches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function show(Church $church)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function edit(Church $church)
    {
      if(Gate::allows('church_manage')) {
        $users = User::where('id',Auth::id())->get();
        $days = [
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
          'Sunday',
        ];
        }
      elseif (Gate::allows('users_manage')) {
        $users = User::where('id','!=',Auth::id())->get();
        $days = [
          'Monday',
          'Tuesday',
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
          'Sunday',
        ];
        }
        $church['days'] = json_decode($church->days);
        return view('admin.churchs.edit', compact('church', 'users','days'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChurchRequest $request, Church $church)
    {

        try {
            $image = $request->file('eventimage');
            $imageEvent = $this->saveImages($image,'event');

            $jsonEncode = array_merge(json_decode($church->eventimage),$imageEvent);
            $churchSave = Church::find($church->id);
            $churchSave->user_id =  $request->get('user_id');
            $churchSave->name =  $request->get('name');
            $churchSave->location =  $request->get('location');
            $churchSave->denomination = $request->get('denomination');
            $churchSave->venue = $request->get('venue');
            $churchSave->days = json_encode($request->get('days'));
            $churchSave->language = $request->get('language');
            $churchSave->Social = $request->get('Social');
            $churchSave->vision = $request->get('vision');
            $churchSave->leadership = $request->get('leadership');
            $churchSave->ministries = $request->get('ministries');
            $churchSave->event = $request->get('event');
            $churchSave->eventimage = json_encode($jsonEncode);

            $churchSave->save();
            toastr()->success('Data has been updated successfully!', 'Church Managemant');
          }
          catch(Exception $e) {
            
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       
        return redirect()->route('admin.churches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Church  $church
     * @return \Illuminate\Http\Response
     */
    public function destroy(Church $church)
    {

        try {
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $church->delete();
            toastr()->success('Data has been deleted successfully!', 'Church Managemant');
          }
          
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
       

        return redirect()->route('admin.churches.index');
    }
}
