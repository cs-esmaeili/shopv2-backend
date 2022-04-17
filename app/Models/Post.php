<?php

namespace App\Models;

use App\Http\classes\FM;
use App\Http\classes\G;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'post_id';
    protected $guarded = ['post_id'];
    protected $fillable  = ['person_id', 'category_id', 'image', 'status', 'title', 'body', 'description', 'meta_keywords'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'person_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }
    public function imageUrl()
    {
        return $this->belongsTo(File::class, 'image', 'file_id');
    }
    public function publicPosts()
    {
        return $this->where('status' , '=' , 1);
    }
    public function postFullData()
    {
        $post = $this->toArray();
        $temp = FM::getPublicFileLink($this->imageUrl);
        $this['image'] = $temp;
        $temp = $this->category;
        $this['category'] = $temp;
        $this['person'] = $this->person->informations();
        $this['time'] = G::converToShamsi($post['created_at']);
    }
}
