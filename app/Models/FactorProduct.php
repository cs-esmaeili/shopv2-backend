<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactorProduct extends Model
{
    protected $table = 'actor_product';
    protected $primaryKey = 'actor_product_id';
    protected $guarded = ['actor_product_id'];
    protected $fillable  = ['factor_id', 'product_id', 'number', 'price', 'sale_price'];

    public function factor()
    {
        return $this->belongsTo(Factor::class, 'factor_id', 'factor_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
