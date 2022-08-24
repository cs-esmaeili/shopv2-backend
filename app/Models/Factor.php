<?php

namespace App\Models;

use App\Http\classes\G;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = 'factor';
    protected $primaryKey = 'factor_id';
    protected $fillable  = ['person_id', 'person_address_id', 'ref_id', 'status'];

    public function getCreatedAtAttribute($date)
    {
        return G::converToShamsi($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return G::converToShamsi($date);
    }
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
    public function address()
    {
        return $this->belongsTo(PersonAddress::class, 'person_address_id', 'person_address_id');
    }
    public function factorProducts()
    {
        return $this->hasMany(FactorProduct::class, 'factor_id', 'factor_id');
    }
}
