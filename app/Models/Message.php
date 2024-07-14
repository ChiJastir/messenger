<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $fillable = ['chat_id', 'sender_id', 'message'];

    public function chats()
    {
        return $this->hasOne(Chat::class);
    }
    public function users()
    {
        return $this->hasOne(User::class);
    }
}
