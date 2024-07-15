<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function sendMessage(Request $request)
    {
        $chat = $request->all()['chat'];
        $user = $request->all()['user'];
        $message = $request->all()['message'];
        Message::create([
            'chat_id' => $chat['id'],
            'sender_id' => $user['id'],
            'message' => $message,
        ]);
    }
}
