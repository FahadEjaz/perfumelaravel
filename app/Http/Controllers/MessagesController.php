<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessagesController extends Controller
{
    public function submit(Request $request){

        // Validate Data
        $this->validate(
            $request,
            [
                "name" => "required"
            ]
        );

        // Save Data
        $message = new Message;
        $message->name = $request->input('name');
        $message->save();

        // Redirect
        return redirect('/')->with('success','Message Set');
    }

    public function getMessages(){
        $messages = Message::all();        
        return view('messages')->with('messages',$messages);
    }
}
