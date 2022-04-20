<?php

namespace App\Models;

use App\Http\classes\FM;
use App\Http\classes\G;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $guarded = ['product_id'];
    protected $fillable  = ['category_id', 'name', 'price', 'sale_price', 'status', 'stock', 'image_folder', 'review' ,'description'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'product_item', 'product_id', 'item_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
    public function userJournal()
    {
        return $this->hasMany(UserJournal::class, 'product_id', 'product_id');
    }
    public function factorProducts()
    {
        return $this->hasMany(FactorProduct::class, 'product_id', 'product_id');
    }
    public function userCart()
    {
        return $this->hasMany(UserCart::class, 'product_id', 'product_id');
    }
    public function productFullData()
    {
        $product = $this->toArray();
        $location = FM::location($this->image_folder, 'public');
        $temp = FM::folderFilesLinks($location);
        foreach ($temp as  $image) {
            if (str_contains($image['name'], 'p')) {
                $this['image'] = $image['link'];
            }
        }
        $temp1 = $this->category;
        $temp2 = $this->items;
        $this['category'] = $temp1;
        $this['items'] = $temp2;
        $this['time'] = G::converToShamsi($product['created_at']);
    }
}
