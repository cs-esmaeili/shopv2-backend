<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    protected $fillable  = ['key', 'value'];

    public function products()
    {
        return $this->belongsToMany(Token::class, 'product_item', 'item_id', 'product_id');
    }
}
