<?php

namespace App\Http\classes;

use App\Models\Key_Value;
use App\Models\Post;

class View
{
    public  static function sideBar($query)
    {
        $oferPosts = [];
        $lastVideo = [];
        $lastScreenShots = [];

        foreach ($query as $key => $value) {
            if (str_contains($value, '\"location\": 3')) {
                $decode = json_decode($value->value);
                $lastVideo['url'] = $decode->url;
                $lastVideo['url_target'] = $decode->url_target;
            } else if (str_contains($value, '\"location\": 4')) {
                $post_id = json_decode($value->value)->post_id;
                $oferPosts[] = $post_id;
            } else if (str_contains($value, '\"location\": 5')) {
                $lastScreenShots[] = $value->value;
            }
        }
        $oferPosts = Post::whereIn('post_id', $oferPosts)->where('status', '=', 1)->get();
        foreach ($oferPosts as  $value) {
            $value->postFullData();
        }
        return ['oferPosts' => $oferPosts, 'lastVideo' => $lastVideo,  'lastScreenShots' => $lastScreenShots];
    }
}
