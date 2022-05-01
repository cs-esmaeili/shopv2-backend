<?php

namespace App\Models;

use App\Http\classes\FM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $fillable  = ['name', 'type', 'file_id', 'parent_id'];

    public function categoryImage()
    {
        $category = $this->toArray();
        $temp = FM::folderFilesLinks($this->file->location);
        $category['image'] = $temp[0]['link'];
        return $category;
    }
    public function file()
    {
        return $this->hasOne(File::class, 'file_id', 'file_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_id', 'category_id');
    }
    public function postsPagination($pageNumber, $perPage)
    {
        return $this->hasMany(Post::class, 'category_id', 'category_id')
            ->where('post.status', '=', 1)
            ->skip((--$pageNumber) * $perPage)
            ->take($perPage);
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'category_id')
            ->where('post.status', '=', 1);
    }
}
