<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';
    protected $primaryKey = 'permission_id';
    protected $guarded = ['permission_id'];
    protected $fillable  = ['name'];
    protected $hidden = ['pivot'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id');
    }
}
