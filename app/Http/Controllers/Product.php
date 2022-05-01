<?php

namespace App\Http\Controllers;

use App\Http\classes\G;
use App\Models\Item;
use App\Models\Person;
use App\Models\Product_Item;
use App\Models\Product as ModelsProduct;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Product extends Controller
{
    public function createProduct(Request $request)
    {

        $result = DB::transaction(function () use ($request) {
            $data = collect($request->request)->toArray();
            $result1 = ModelsProduct::updateOrCreate(
                ['product_id' => $data['product_id']],
                G::getArrayItems($data, (new ModelsProduct)->getFillable())
            );
            $items = $data['items'];
            $keys = [];
            foreach ($items as $item) {
                $result2 = Item::updateOrCreate(
                    ['item_id' => $item['item_id']],
                    ['key' => $item['key'], 'value' => $item['value']]
                );
                $keys[] = $result2['item_id'];
                Product_Item::updateOrCreate(
                    ['product_id' => $result1['product_id'], 'item_id' => $result2['item_id']],
                    ['product_id' => $result1['product_id'], 'item_id' => $result2['item_id']]
                );
            }
            Log::debug($keys);
            $result4 = Product_Item::where('product_id', '=', $data['product_id'])
                ->whereNotIn('item_id', $keys)->get();

            Product_Item::where('product_id', '=', $data['product_id'])
                ->whereNotIn('item_id', $keys)->delete();

            foreach ($result4 as $item) {
                Item::where('item_id', '=', $item->item_id)->delete();
            }
            return true;
        });
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "کالا اضافه شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "کالا اضافه نشد"], 201);
        }
    }
    public function productList(Request $request)
    {
        $result = ModelsProduct::all();
        foreach ($result as $product) {
            $product->productFullData();
        }
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $result], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "خطای در بازیابی اطلاعات رخ داد دوباره سعی کنید"], 201);
        }
    }
    public function deleteProduct(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $content =  json_decode($request->getContent());

            $result = ModelsProduct::where('product_id', '=', $content->product_id)->get();
            foreach ($result[0]->items as $item) {
                Item::where('item_id', '=', $item->item_id)->delete();
            }
            $result = ModelsProduct::where('product_id', '=', $content->product_id)->delete();
            return true;
        });
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "کالا حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "کالا حذف نشد"], 201);
        }
    }
    public function productData(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = ModelsProduct::where('product_id', '=', $content->product_id)->get();
        foreach ($result as  $value) {
            $value->productFullData();
        }
        if ($result->count() == 1) {
            return response(['statusText' => 'ok', 'data' => $result[0]], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "خطای در بازیابی اطلاعات رخ داد دوباره سعی کنید"], 201);
        }
    }
    public function addCart(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = UserCart::create([
            'person_id' => $person->person_id,
            'product_id' => $content->product_id,
            'number' => $content->number,
        ]);
        if ($result->exists) {
            return response(['statusText' => 'ok', 'message' => 'کالا به سبد خرید اضافه شد'], 200);
        } else {
            return response(['statusText' => 'ok', 'message' => 'خطای رخ داد دوباره تلاش کنید'], 200);
        }
    }
    public function deleteCart(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = UserCart::where([
            'person_id' => $person->person_id,
            'product_id' => $content->product_id,
        ])->delete();
        if ($result) {
            return response(['statusText' => 'ok', 'message' => 'کالا از سبد خرید حذف شد'], 200);
        } else {
            return response(['statusText' => 'ok', 'message' => 'کالا از سبد خرید حذف نشد'], 200);
        }
    }
    public function listCart(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $result = UserCart::where('person_id', '=', $person->person_id)->get();
        $outPut = [];

        foreach ($result as $product) {
            $product->product->productFullData();
            $temp = $product->product->toArray();
            $temp['number'] = $product->number;
            $outPut[] = $temp;
        }
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $outPut], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "خطای در بازیابی اطلاعات رخ داد دوباره سعی کنید"], 201);
        }
    }
    public function cartChangeNumber(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = UserCart::where([
            'person_id' => $person->person_id,
            'product_id' => $content->product_id,
        ])->update(['number' => $content->number]);

        if ($result > 0) {
            return response(['statusText' => 'ok', 'message' => 'تعداد کالا تغییر پیدا کرد'], 200);
        } else {
            return response(['statusText' => 'fail', 'message' =>  'تعداد کالا تغییر پیدا نکرد'], 201);
        }
    }
    public function categoryProducts(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = ModelsProduct::where('category_id', '=', $content->category_id)->get();
        foreach ($result as $product) {
            $product->productFullData();
        }
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $result], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "خطای در بازیابی اطلاعات رخ داد دوباره سعی کنید"], 201);
        }
    }
}
