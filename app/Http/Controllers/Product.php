<?php

namespace App\Http\Controllers;

use App\Http\classes\G;
use App\Models\Product as ModelsProduct;
use Illuminate\Http\Request;

class Product extends Controller
{
    public function createProduct(Request $request)
    {
        $data = collect($request->request)->toArray();
        $result = ModelsProduct::updateOrCreate(['product_id' => $data['product_id']], G::getArrayItems($data, (new ModelsProduct)->getFillable()));
        if ($result->exists) {
            return response(['statusText' => 'ok', 'message' => "کالا اضافه شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "کالا اضافه نشد"], 201);
        }
    }
    public function productList(Request $request)
    {
        $result = ModelsProduct::all();
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $result], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "کالا اضافه نشد"], 201);
        }
    }
    public function deleteProduct(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = ModelsProduct::where('product_id', '=', $content->product_id)->delete();
        if ($result == 1) {
            return response(['statusText' => 'ok', 'message' => "کالا حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "کالا حذف نشد"], 201);
        }
    }
}
