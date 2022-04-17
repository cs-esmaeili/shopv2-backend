<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Key_Value extends Model
{
    protected $table = 'key_value';
    protected $primaryKey = 'key_value_id';
    protected $fillable  = ['key', 'value'];
}
