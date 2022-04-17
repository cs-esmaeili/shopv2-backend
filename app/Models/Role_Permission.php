<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Role_Permission extends Model
{
    protected $hidden = ['pivot'];
    protected $table = 'role_permission';
    protected $fillable  = ['role_id', 'permission_id'];
}
