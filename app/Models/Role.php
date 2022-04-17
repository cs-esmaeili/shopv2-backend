<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $guarded = ['role_id'];
    protected $fillable  = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
    public function persons()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
}
