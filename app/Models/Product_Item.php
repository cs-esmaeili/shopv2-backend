<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Item extends Model
{
    protected $table = 'product_item';
    protected $fillable  = ['product_id', 'item_id'];
    protected $hidden = ['pivot'];
}
