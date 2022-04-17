<?php

namespace App\Http\Controllers;

use App\Http\classes\FM;
use App\Http\classes\G;
use App\Http\classes\View;
use App\Models\Key_Value;
use App\Models\Post;
use App\Models\Product;

class IndexPage extends Controller
{
    public function sliderImages()
    {
        $result = Key_Value::where('key', '=', 'indexPage')->where('value', 'LIKE', '%"location": 1%')->get();
        return response(['statusText' => 'ok', "list" => $result], 200);
    }



    public function indexPageView()
    {
        $result = Key_Value::where('key', '=', 'indexPage')->get();

        $silder = [];
        $posts = [];
        $lastPictures = [];


        foreach ($result as $key => $value) {
            if (str_contains($value, '\"location\": 1')) {
                $silder[] = $value;
            } else if (str_contains($value, '\"location\": 2')) {
                $post_id = json_decode($value->value)->post_id;
                $posts[] = $post_id;
            } else if (str_contains($value, '\"location\": 6')) {
                $lastPictures[] = $value->value;
            }
        }

        $lastPosts = Post::where('status', '=', 1)->orderBy('post_id', 'desc')->take(3)->get();
        $product1 = Product::where('category_id', '=', 1)->take(4)->get();
        $product2 = Product::where('category_id', '=', 2)->take(4)->get();
        $product3 = Product::where('category_id', '=', 3)->take(4)->get();
        $product4 = Product::where('category_id', '=', 4)->take(3)->get();
        $product5 = Product::where('category_id', '=', 5)->take(8)->get();

        foreach ($lastPosts as  $value) {
            $value->postFullData();
        }
        foreach ($product1 as  $value) {
            $value->productFullData();
        }
        foreach ($product2 as  $value) {
            $value->productFullData();
        }
        foreach ($product3 as  $value) {
            $value->productFullData();
        }
        foreach ($product4 as  $value) {
            $value->productFullData();
        }
        foreach ($product5 as  $value) {
            $value->productFullData();
        }
        $data = ['slider' => $silder, 'latestPosts' => $lastPosts, 'products3x' => [$product1, $product2, $product3]
        , 'special' => $product4
        , 'moreSeal' => $product5
    ];

        return view('pages.home', ['data' => $data]);
    }
}
