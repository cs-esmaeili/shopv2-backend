<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'token';
    protected $primaryKey = 'token_id';
    protected $guarded = ['token_id'];
    protected $fillable  = ['token', 'expiration'];

    public function person()
    {
        return $this->belongsTo(Person::class, "token_id", "token_id");
    }

    public function file()
    {
        return $this->belongsToMany(File::class, 'file_token', 'token_id', 'file_id');
    }
}
