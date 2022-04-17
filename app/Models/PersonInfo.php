<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonInfo extends Model
{
    protected $table = 'person_info';
    protected $primaryKey = 'person_info_id';
    protected $fillable  = ['person_id', 'file_id', 'name', 'family', 'description'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
    public function file()
    {
        return $this->hasOne(File::class, 'file_id', 'file_id');
    }

}
