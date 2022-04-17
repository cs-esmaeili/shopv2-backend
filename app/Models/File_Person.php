<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File_Person extends Model
{
    protected $table = 'file_person';
    protected $fillable  = ['file_id', 'person_id'];
    protected $hidden = ['pivot'];
}
