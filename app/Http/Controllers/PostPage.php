<?php

namespace App\Http\Controllers;

use App\Http\classes\View;
use App\Models\Key_Value;
use App\Models\Post;
use Illuminate\Http\Request;

class PostPage extends Controller
{
    public function postPageView(Request $request)
    {
        $post = Post::where('post_id', '=', $request->post_id)->where('status', '=', 1)->get();
        if (count($post) == 0) {
            abort(404);
        }
        $post = $post[0];
        $post->postFullData();
        $result = Key_Value::where('key', '=', 'indexPage')->get();
        $sidebar =  View::sideBar($result);

        $relatedPost = Post::where('post_id', '!=', $request->post_id)->orderBy('post_id', 'desc')->take(2)->get();
        foreach ($relatedPost as  $value) {
            $value->postFullData();
        }

        $data = ['relatedPost' => $relatedPost, 'oferPosts' => $sidebar['oferPosts'], 'lastVideo' => $sidebar['lastVideo'],  'lastScreenShots' => $sidebar['lastScreenShots'], 'post' => $post];
        return view('pages.post', ['data' => $data]);
    }
}
