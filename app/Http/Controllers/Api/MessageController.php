<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Group;

use App\Events\MessageEvent;
use App\models\Api\Group as ApiGroup;
use App\models\Api\group_participants;
use App\models\Api\Message as ApiMessage;
use GuzzleHttp\Psr7\Message as Psr7Message;
use Symfony\Component\Mime\Message as MimeMessage;

class MessageController extends Controller
{
    public function __construct()
    {
       // $this->middleware('member');
    }

    //show messages from a group
    public function show_messages($id)
    {
        $group = Group::find($id);

        $messages = $group->messages()->with(['group', 'user'])->get();

        $user_loggedIn = auth()->user();

        return ['messages' => $messages, 'user_loggedIn' => $user_loggedIn];
    }

    public function send_message(Request $request, $id)
    {   
        $this->validate($request, [
            'message' => 'required',
            'message_type' => 'required',
        ]);

        $groupParticipants = group_participants::where('group_id',$id)
                ->where('user_id',auth()->user()->id)
                ->first();
        if($groupParticipants->status == 0){
            return response()->json([
                'success' => false,
                'message' => 'Not have permission',
                //'data' =>$messages,
                ]);
        }elseif($groupParticipants->status == 1){
            return response()->json([
                'success' => false,
                'message' => 'Request panding',
                //'data' =>$messages,
                ]);
        }else{
            $message = ApiMessage::create([
                'user_id' => auth()->user()->id,
                'group_id' => $id,
                'message' => $request->message,
                'message_type' => $request->message_type,
            ])->with(['group', 'user'])->latest()->first();
    
            //update the group. The update_at date will help list groups from the most recent to the oldest
            $group = ApiGroup::find($message->group_id);
    
            $group->update(['updated_at' => $message->updated_at]);
           // event(new MessageEvent($message));
    
           return response()->json([
            'success' => true,
            'message' => 'Message Send',
            //'data' =>$messages,
            ]);
        }
      

        //return redirect()->back();
    }

    public function typemessage($id){
            
            $messages = ApiMessage::where('message_type',$id)->get();
            
            if(count($messages) == 0){
                return response()->json([
                    'success' => false,
                    'message' => 'Recode not found!',
                ]);
            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'Messages List',
                    'data' => $messages,
                ]);
            }
                
        
    }
}
