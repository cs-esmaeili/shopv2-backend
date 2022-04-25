<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonAddress extends Model
{
    protected $table = 'person_address';
    protected $primaryKey = 'person_address_id';
    protected $fillable  = ['person_id', 'state', 'city', 'postal_code', 'address'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }

}
