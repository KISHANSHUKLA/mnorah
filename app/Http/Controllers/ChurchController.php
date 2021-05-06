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
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $churches = Church::with('user')
            ->get();
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
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $users = User::where('id','!=',Auth::id())->get();
            //toastr()->success('Data has been saved successfully!', 'Church Managemant');
          }
          
          //catch exception
          catch(Exception $e) {
            toastr()->error('An error has occurred please try again later.', $e->getMessage());
          }
      
        return view('admin.churchs.create', compact('users'));
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
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $image = $request->file('eventimage');
            $imageEvent = $this->saveImages($image,'event');

            Church::create([
            'user_id' => $request->user_id,
            'denomination' => $request->denomination,
            'venue' => $request->venue,
            'days' => $request->days,
            'language' => $request->language,
            'Social' => $request->Social,
            'vision' => $request->vision,
            'leadership' => $request->leadership,
            'ministries' => $request->ministries,
            'event' => $request->event,
            'eventimage' => $imageEvent,
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
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $users = User::where('id','!=',Auth::id())->get();

        return view('admin.churchs.edit', compact('church', 'users'));
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
            if (! Gate::allows('users_manage')) {
                return abort(401);
            }
            $image = $request->file('eventimage');
            $imageEvent = $this->saveImages($image,'event');

            $contact = Church::find($church->id);
            $contact->user_id =  $request->get('user_id');
            $contact->denomination = $request->get('denomination');
            $contact->venue = $request->get('venue');
            $contact->days = $request->get('days');
            $contact->language = $request->get('language');
            $contact->Social = $request->get('Social');
            $contact->vision = $request->get('vision');
            $contact->leadership = $request->get('leadership');
            $contact->ministries = $request->get('ministries');
            $contact->event = $request->get('event');
            $contact->eventimage = $imageEvent;

            $contact->save();


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
