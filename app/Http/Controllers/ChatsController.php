<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatsController extends Controller
{
    public function showAddNewChat(Request $request)
    {
        if ($request->query()){
            $users = User::where('name','LIKE',"%{$request->query()['name']}%")->get();
        }else{
            $users = User::all();
        }
        return Inertia::render('AddChat', ['users' => $users]);
    }
}
