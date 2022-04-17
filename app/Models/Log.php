<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'log_id';
    protected $fillable  = ['type', 'title' ,'content'];
}
