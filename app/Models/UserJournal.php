<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserJournal extends Model
{
    protected $table = 'user_journal';
    protected $primaryKey = 'user_journal_id';
    protected $guarded = ['user_journal_id'];
    protected $fillable  = ['person_id', 'ref_id', 'authority_code', 'done', 'price', 'postal_code', 'name', 'phone_number', 'state', 'city', 'address', 'description'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }

    public function UserJournalProduct()
    {
        return $this->hasMany(UserJournalProduct::class, 'user_journal_id', 'user_journal_id');
    }
}
