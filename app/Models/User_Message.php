<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Message extends Model
{
    protected $table = 'user_message';
    protected $primaryKey = 'user_message_id';
    protected $fillable  = ['name', 'email', 'message'];
}
