<?php

namespace App\Http\Controllers;

use App\Http\classes\View;
use App\Models\Category;
use App\Models\Key_Value;
use Illuminate\Http\Request;

class CategoryPage extends Controller
{
    public function categoryPageView(Request $request)
    {
        $category = Category::where('category_id', '=', $request->category_id)->get();
        $posts = null;
        $count = null;
        $perPage = 8;
        if (count($category) == 1) {
            $posts = $category[0]->postsPagination($request->page_number, $perPage)->get();
            $count = count($category[0]->posts);
        } else {
            abort(404);
        }
        foreach ($posts as  $value) {
            $value->postFullData();
        }
        $result = Key_Value::where('key', '=', 'indexPage')->get();
        $sidebar =  View::sideBar($result);
        $data = [
            'posts' => $posts,
            'oferPosts' => $sidebar['oferPosts'],
            'lastVideo' => $sidebar['lastVideo'],
            'lastScreenShots' => $sidebar['lastScreenShots'],
            'pagination' => [
                'postsCount' => $count,
                'perPage' => $perPage,
                'currentPage' => $request->page_number,
                'category_id' => $request->category_id,
            ],
        ];
        return view('pages.category', ['data' => $data]);
    }
}
