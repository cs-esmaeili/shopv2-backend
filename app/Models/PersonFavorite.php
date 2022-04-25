<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonFavorite extends Model
{
    protected $table = 'person_favorite';
    protected $primaryKey = 'person_favorite_id';
    protected $fillable  = ['person_id', 'product_id'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }

}

