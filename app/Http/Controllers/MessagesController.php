<?php

namespace App\Http\Controllers;

use App\Events\Chat\MessageSent;
use App\Events\TestEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use function React\Promise\all;

class MessagesController extends Controller
{
    public function sendMessage(Request $request)
    {
//        dd($request->all()['chat']);
        $chat = $request->all()['chat'];
        $user = $request->all()['user'];
        $message = $request->all()['message'];
        Message::create([
            'chat_id' => $chat['id'],
            'sender_id' => $user['id'],
            'message' => $message,
        ]);
    }

    public function sentMessage(Request $request)
    {
        $chat = Chat::where('id', '=', $request->all()['chat']['id'])->get()[0];
        $user = $request->all()['user'];
        $message = Message::create([
            'chat_id' => $chat['id'],
            'sender_id' => $user['id'],
            'message' => $request->all()['message'],
        ]);
        event(new MessageSent(
            chat: $chat,
            user: $user['id'],
            message: $message
        ));
    }
}
