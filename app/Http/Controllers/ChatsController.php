<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $chat = User::where('id','=', $request->all()['id'])->get();
        return Inertia::render('Chat', ['chat' => $chat[0]]);
    }

    public function checkChat(Request $request)
    {
        $first_user_id = $request->all()['first_user_id'];
        $second_user_id = $request->all()['second_user_id'];

        $chat = Chat::where([
            ['first_user_id', '=', $first_user_id],
            ['second_user_id', '=', $second_user_id],
        ])->orWhere([
            ['first_user_id', '=', $second_user_id],
            ['second_user_id', '=', $first_user_id],
        ])->get();

        if (count($chat) != 0)
        {
            dd('already exist');
        }
        else
        {
            dd('not exist');
        }
    }

    public function createChat(Request $request)
    {
        $first_user_id = $request->all()['first_user_id'];
        $second_user_id = $request->all()['second_user_id'];

        $chat = Chat::where([
            ['first_user_id', '=', $first_user_id],
            ['second_user_id', '=', $second_user_id],
        ])->orWhere([
            ['first_user_id', '=', $second_user_id],
            ['second_user_id', '=', $first_user_id],
        ])->get();

        if (count($chat) != 0)
        {
            dd('already exist');
        }
        else
        {
            Chat::create([
                'first_user_id' => $first_user_id,
                'second_user_id' => $second_user_id,
            ]);
        }
    }
}
