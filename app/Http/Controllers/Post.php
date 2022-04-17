<?php

namespace App\Http\Controllers;

use App\Http\classes\G;
use  \App\Models\Post as MPost;
use Illuminate\Http\Request;

class Post extends Controller
{
    public function createPost(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $content =  json_decode($request->getContent());

        $result = MPost::where('title', '=', $content->title)->get();
        if ($result->count() != 0) {
            return response(['statusText' => 'fail', 'message' => "عنوان باید منحصر به فرد باشد"], 200);
        }
        $result = MPost::create([
            'person_id' => $person->person_id,
            'category_id'  => $content->category_id,
            'image' => $content->image,
            'status' => $content->status,
            'title' => $content->title,
            'body' => $content->body,
            'description' => $content->description,
            'meta_keywords' => $content->meta_keywords,
        ]);
        if ($result->count() > 0) {
            return response(['statusText' => 'ok', 'message' => "مطلب اضافه شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "مطلب اضافه نشد"], 200);
        }
    }
    public function postList()
    {
        $list = MPost::all();
        $newList = [];
        for ($i = 0; $i < $list->count(); $i++) {
            $temp = $list[$i]->toArray();
            $temp['person'] =  $list[$i]->person->informations();
            $newList[] = $temp;
        }
        return response(['statusText' => 'ok', 'list' => $newList], 200);
    }
    public function deletePost(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = MPost::where('post_id', '=', $content->post_id)->delete();
        if ($result == 1) {
            return response(['statusText' => 'ok', 'message' => "مظلب حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "مظلب حذف نشد"], 200);
        }
    }
    public function changePostStatus(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = MPost::where('post_id', '=', $content->post_id)->update(['status' => $content->status]);
        if ($result == 1) {
            return response(['statusText' => 'ok', 'message' => "وضعیت مطلب تغییر کرد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "وضعیت مطلب تغییر نکرد"], 200);
        }
    }
    public function updatePost(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = MPost::where('post_id', '=', $content->post_id)->update([
            'category_id'  => $content->category_id,
            'image' => $content->image,
            'status' => $content->status,
            'title' => $content->title,
            'body' => $content->body,
            'description' => $content->description,
            'meta_keywords' => $content->meta_keywords,
        ]);
        if ($result == 1) {
            return response(['statusText' => 'ok', 'message' => "مطلب تغییر کرد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' =>  "مطلب تغییر نکرد"], 200);
        }
    }
}
