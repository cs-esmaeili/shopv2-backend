<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJournalProduct extends Model
{
    protected $table = 'user_journal_product';
    protected $primaryKey = 'user_journal_product_id';
    protected $guarded = ['user_journal_product_id'];
    protected $fillable  = ['user_journal_id', 'product_id', 'number', 'price', 'old_price'];


    public function userjournal()
    {
        return $this->belongsTo(UserJournal::class, 'user_journal_id', 'user_journal_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
