<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\models\Api\Group as ApiGroup;
use App\models\Api\group_participants;
use App\models\Api\Types;
use Illuminate\Http\Request;

use App\Models\Group;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //some functions can only be executed by group admin/owner
       // $this->middleware('owner')->only(['edit', 'update', 'delete', 'remove_user']);

        //the group will only be accessed by a member
       // $this->middleware('member')->only('show');
    }

    // //display form to create a group
    // public function create_form()
    // {
    //     return view('group.create');
    // }

    public function create(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required'
        ]);

        //generate a code for the groupe
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = substr(str_shuffle($characters), rand(0, 9), 7);

        $group = ApiGroup::create([
            'name' => $request->name,
            'code' => $code,
            'admin_id' => auth()->user()->id,
        ]);
        
        //we attach the user with the group after he created it
       $group->participants()->attach(auth()->user()->id);

       return response()->json([
        'success' => true,
        'message' => 'Your group has been created',
        'data' => $group,
    ]);

       // return redirect('/home')->with('success', 'Your group has been created');
    }

    public function getGroups(){
        
        //get group where user is present
            $groups = auth()->user()->group_member;
        
            return response()->json([
                'success' => true,
                'message' => 'Groups List',
                'data' => $groups,
            ]);
            
    }

    //display the form to join a group
    public function join_form()
    {
        return view('group.join');
    }

    //user join a group by entering the code
    public function join(Request $request)
    {   
       
        $this->validate($request, [
            'group_id' => 'required'
        ]);

        $group_id = $request->group_id;

        $group = ApiGroup::where('id', $group_id)->first();
        
        //if the group exists
        if ($group)
        {
            try 
            {
                //we add the user to the group and we redirect him to the home page with a success message
                $group->participantsData()->attach(auth()->user()->id);
                
                $groupParticipants = group_participants::where('group_id',$group_id)
                ->where('user_id',auth()->user()->id)
                ->first();
                
                $groupParticipantsData = group_participants::find($groupParticipants->id);
                $groupParticipantsData->status = 1;
        
                $groupParticipantsData->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Group joined',
                ]);

            } 
            catch (\Throwable $th) 
            { 
                //Display an error if the user is already in the group
                return response()->json([
                    'success' => false,
                    'message' => 'You are already a member of this group',
                ]);
            }
        }
        else
        {
            //if the group doesn't exist we throw an error
            return response()->json([
                'success' => false,
                'message' => 'Group not found',
            ]);
        }
    }

    //show group page with messages
    public function show_group($id)
    {
        $group = ApiGroup::find($id);

        if($group){
            $messages = $group->messages()->get();
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Recode not found!',
            ]);
        }
      
        return response()->json([
            'success' => true,
            'message' => 'Group Messages',
            'data' =>$messages,
        ]);
        //return view('group.show', compact(['group', 'messages']));
    }

    //display the form to edit the name of a group
    public function edit($id)
    {
        $group = ApiGroup::find($id);

        return view('group.edit', compact('group'));
    }

    //change the name of the group
    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required'
        ]);

        $group = ApiGroup::find($id);
        $group->name = $request->name;

        $group->save();

        return response()->json([
            'success' => true,
            'message' => 'Group name has been changed',
            'data' => $group,
        ]);

        //return redirect('/group/'. $id)->with('success', 'Group name has been changed');
    }

    //delete a groupe and remove every participant
    public function delete($id)
    {
        $group = ApiGroup::find($id);

        $group->participants()->detach();

        $group->delete();

        return response()->json([
            'success' => true,
            'message' => 'Group has been deleted',
            //'data' => $group,
        ]);

        //return redirect('/home')->with('success', '');
    }

    //display the members of a group, the admin can then decide who to remove
    public function members_list($id)
    {
        $group = ApiGroup::find($id);

        $group_members = $group->participants()->get();

        $group_id = $id;

        return view('group.members_list', compact(['group_members', 'group_id']));
    }

    //remove the user from a group
    public function remove_user($id, $user_id)
    {
        $group = ApiGroup::find($id);

        $group->participants()->detach($id);

        return redirect()->back()->with('success', 'A user has been removed');
    }


    public function types(){
        
        //get group where user is present
            $types = Types::get();
        
            return response()->json([
                'success' => true,
                'message' => 'types List',
                'data' => $types,
            ]);
            
    }
}
