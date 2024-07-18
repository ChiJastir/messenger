<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatsController extends Controller
{
    public function showAddNewChat(Request $request)
    {
        if ($request->all()){
            $users = User::where('name','LIKE',"%{$request->all()['name']}%")->get();
        }else{
            $users = User::all();
        }
        return Inertia::render('AddChat', ['users' => $users]);
    }

    public function showChat(Request $request)
    {
        $first_user_id = $request->all()['first'];
        $second_user_id = $request->all()['second'];

        $chat = Chat::where([
            ['first_user_id', '=', $first_user_id],
            ['second_user_id', '=', $second_user_id],
        ])->orWhere([
            ['first_user_id', '=', $second_user_id],
            ['second_user_id', '=', $first_user_id],
        ])->get();

        $interlocutor = User::where('id','=', $second_user_id)->get();
        if(count($chat) != 0){
            $messages = Message::where('chat_id', '=', $chat[0]->id)->get();
        }
        else{
            $messages = [];
        }
//        dd($messages);
        return Inertia::render('Chat', ['interlocutor' => $interlocutor[0], 'chat' => $chat, 'messages' => $messages]);
    }

    public function createChat(Request $request)
    {
        $first_user = $request->all()['first_user'];
        $second_user = $request->all()['second_user'];
        $message = $request->all()['message'];

        $chat = Chat::create([
            'first_user_id' => $first_user['id'],
            'second_user_id' => $second_user['id'],
        ]);

        $response = [
            'chat' => $chat[0],
            'user' => $first_user,
            'message' => $message,
        ];

        (new MessagesController)->sendMessage($response);
    }
}
