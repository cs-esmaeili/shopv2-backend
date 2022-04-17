<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table = 'user_cart';
    protected $primaryKey = 'user_cart_id';
    protected $guarded = ['user_cart_id'];
    protected $fillable  = ['person_id', 'product_id', 'number'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'product_id', 'product_id');
    }
}
