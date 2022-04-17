<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = 'factor';
    protected $primaryKey = 'factor_id';
    protected $fillable  = ['person_id', 'ref_id', 'postal_code', 'price', 'name', 'phone_number', 'state', 'city', 'address', 'description'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
    public function factorProducts()
    {
        return $this->hasMany(FactorProduct::class, 'factor_id', 'factor_id');
    }
}
