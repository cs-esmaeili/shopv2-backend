<?php

namespace App\Http\Controllers;

use App\Models\Category as ModelsCategory;
use Illuminate\Http\Request;

class Category extends Controller
{
    public function categoryListPyramid(Request $request)
    {
        $all = ModelsCategory::all();
        $list = [];
        $indexs = [];
        for ($i = 0; $i < count($all); $i++) {
            $boolean = true;
            foreach ($indexs as $value) {
                if ($all[$i]->category_id == $value) {
                    $boolean = false;
                    break;
                }
            }
            if ($boolean == false) {
                continue;
            }
            $temp =  $this->categoryChilds($all[$i], $all);
            foreach ($temp['indexs'] as $value) {
                $indexs[] = $value;
            }
            $list[] = $temp['category'];
        }

        return response(['statusText' => 'ok', "list" => $list], 200);
    }
    private function categoryChilds($category, $all)
    {
        $items = [];
        $indexs = [];
        for ($i = 0; $i < count($all); $i++) {
            if (($all[$i] != null && !is_array($all[$i])) && ($all[$i]->parent_id == $category->category_id)) {
                $result = $this->categoryChilds($all[$i], $all);
                $items[] = $result['category'];
                $indexs[] = $all[$i]->category_id;
                foreach ($result['indexs'] as $value) {
                    $indexs[] = $value;
                }
            }
        }
        if (count($items) > 0) {
            $category = array($category, $items);
        }
        return ['category' => $category, 'indexs' => $indexs];
    }
    public function categoryListPure()
    {
        $result = ModelsCategory::all();
        return response(['statusText' => 'ok', "list" => $result], 200);
    }
    public function addCategory(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = ModelsCategory::create([
            'name' => $content->name,
            'type' => $content->type,
            'file_id' => $content->file_id,
            'parent_id' => $content->parent_id,
        ]);
        if ($result->count() > 0) {
            return response(['statusText' => 'ok', "message" => "دسته بندی ساخته شد"], 200);
        } else {
            return response(['statusText' => 'fail', "message" => "دسته بندی ساخته نشد"], 200);
        }
    }
    public function deleteCategory(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = ModelsCategory::where('category_id', '=', $content->category_id)->Orwhere('parent_id', '=', $content->category_id)->delete();
        if ($result) {
            return response(['statusText' => 'ok', "message" => "دسته بندی حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', "message" => "دسته بندی حذف نشد"], 200);
        }
    }
}
