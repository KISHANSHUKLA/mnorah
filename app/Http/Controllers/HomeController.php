<?php

namespace App\Http\Controllers;

use App\Appuser;
use App\Http\Requests;
use App\models\Api\events;
use App\models\Church;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = events::with('user')
        ->where("status",0)->get();
        
        $appUser = Appuser::count();
        $churchCount = Church::count();
        $feedCount = events::
        where('status',1)
        ->count();
        
        return view('home',compact('events','appUser','churchCount','feedCount'));
    }
}
