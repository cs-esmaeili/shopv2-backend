<?php

namespace App\Http\Controllers;

use App\Http\classes\FileManager;
use App\Http\classes\FM;
use App\Http\classes\G;
use App\Http\Requests\addPermission;
use App\Http\Requests\addRole;
use App\Http\Requests\createPerson;
use App\Http\Requests\deletePermission;
use App\Http\Requests\deleteRole;
use App\Http\Requests\editPerson;
use App\Http\Requests\editRole;
use App\Http\Requests\missingPermissionss;
use App\Http\Requests\permissions;
use App\Http\Requests\rolePermissions;
use App\Models\Factor;
use App\Models\FactorProduct;
use App\Models\PersonAddress;
use App\Models\Permission;
use App\Models\Person as ModelsPerson;
use App\Models\PersonFavorite;
use App\Models\PersonInfo;
use App\Models\Product;
use App\Models\Role;
use App\Models\Role_Permission;
use App\Models\User_Message;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Person extends Controller
{
    public function personProfile(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $permission = $person->role->permissions()->select(['name'])->get()->toArray();
        $permission_new = [];
        foreach ($permission as $value) {
            $permission_new[] = $value['name'];
        }
        return response(['statusText' => 'ok', 'information' => $person->informations(), 'permissions' => $permission_new], 200);
    }
    public function admins()
    {
        $persons = ModelsPerson::all();
        $admins = collect();
        foreach ($persons as $person) {
            if (strpos($person->role->name, 'Admin') !== false) {
                $admins->push($person->informations());
            }
        }
        return response(['statusText' => 'ok', "list" => $admins], 200);
    }

    public function adminRoles()
    {
        $roles = Role::where('name', 'LIKE', "%Admin%")->get(['name', 'role_id']);
        return response(['statusText' => 'ok', "list" => $roles], 200);
    }

    public function roles()
    {
        $roles = Role::all(['name', 'role_id']);
        return response(['statusText' => 'ok', "list" => $roles], 200);
    }
    public function rolePermissions(rolePermissions $request)
    {
        $content =  json_decode($request->getContent());
        $permissions = Role::where('role_id', '=', $content->role_id)->get()[0]->permissions;
        return response(['statusText' => 'ok', "list" => $permissions], 200);
    }
    public function missingPermissions(missingPermissionss $request)
    {
        $content =  json_decode($request->getContent());
        $permissions = Role::where('role_id', '=', $content->role_id)->get();
        if ($permissions->count() > 0) {
            $permissions = $permissions[0]->permissions()->get(['permission.permission_id'])->toArray();
            $outPermissions = [];
            foreach ($permissions as $key => $value) {
                $outPermissions[] = $value['permission_id'];
            }
            $miss =  Permission::whereNotIn('permission_id', $outPermissions)->get();
            return response(['statusText' => 'ok', "list" => $miss], 200);
        } else {
            return response(['statusText' => 'ok', "list" => null], 200);
        }
    }

    public function addRole(addRole $request)
    {
        $content =  json_decode($request->getContent());
        Role::create([
            'name' => $content->name,
        ]);
        return response(['statusText' => 'ok', 'message' => "نقش ساخته شد"], 200);
    }
    public function deleteRole(deleteRole $request)
    {
        $content =  json_decode($request->getContent());
        ModelsPerson::where('role_id', '=', $content->role_id)->update(['role_id' => $content->new_role_id]);
        $result = Role::where('role_id', '=', $content->role_id)->delete();
        return response(['statusText' => 'ok', "message" => 'نقش مورد نظر حذف شد'], 200);
    }
    public function editRole(editRole $request)
    {
        $content =  json_decode($request->getContent());
        Role::where('role_id', '=',  $content->role_id)->update([
            'name' => $content->name,
        ]);
        return response(['statusText' => 'ok'], 200);
    }

    public function addPermission(addPermission $request)
    {
        $content =  json_decode($request->getContent());
        Role_Permission::create([
            'role_id' => $content->role_id,
            'permission_id' => $content->permission_id,
        ]);
        return response(['statusText' => 'ok', 'message' => "دسترسی اضافه شد"], 200);
    }

    public function deletePermission(deletePermission $request)
    {
        $content =  json_decode($request->getContent());
        Role_Permission::where('role_id', '=', $content->role_id)->where('permission_id', '=', $content->permission_id)->delete();
        return response(['statusText' => 'ok', 'message' => "دسترسی حذف شد"], 200);
    }

    public function createPerson(createPerson $request)
    {
        $content =  json_decode($request->getContent());
        $search = ModelsPerson::where('username', '=', G::changeWords($content->username))->get();
        if ($search->count() != 0) {
            return response(['statusText' => 'fail', 'message' => "نام کاربری باید منحصر به فرد باشد"], 406);
        } else {
            $result =  DB::transaction(function () use ($content) {
                $token_id = G::newToken($content->username)['token_id'];
                $person = ModelsPerson::create([
                    'username' => G::changeWords($content->username),
                    'password' => G::getHash(G::changeWords($content->password)),
                    'role_id' => $content->role_id,
                    'token_id' => $token_id,
                    'status' => 1,
                ]);
                PersonInfo::create([
                    'person_id' => $person->person_id,
                    'file_id' => $content->file_id,
                    'name' => $content->name,
                    'family' => $content->family,
                    'description' => $content->description,
                ]);
                return response(['statusText' => 'ok', 'message' => "حساب ساخته شد"], 201);
            });
            return $result;
        }
    }

    public function editPerson(editPerson $request)
    {
        $content =  json_decode($request->getContent());
        $search = ModelsPerson::where('person_id', '=', $content->person_id)->get();
        if ($search->count() == 0) {
            return response(['statusText' => 'fail', 'message' => "کار بر یافت نشد"], 406);
        } else {
            $data = collect($request->request)->toArray();
            $temp = null;
            if (array_key_exists('password', $data)) {
                $token_id = G::newToken($content->person_id, $search[0]->token->token_id)['token_id'];
                $temp = ['token_id' => $token_id, 'password' => G::getHash($data['password'])];
            }
            $search[0]->update(G::getArrayItems($data, (new ModelsPerson)->getFillable(), $temp));
            $search[0]->personInfo()->update(G::getArrayItems($data, (new PersonInfo)->getFillable()));
            return response(['statusText' => 'ok', 'message' => "تغییرات ذخیره شد"], 201);
        }
    }

    public function contactUs(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = User_Message::create([
            'email' => $content->email,
            'name' => $content->name,
            'message' => $content->message
        ]);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "پیام ذخیره شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "پیام ذخیره نشد"], 200);
        }
    }
    public function addAddress(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonAddress::create([
            'person_id' => $person->person_id,
            'state' => $content->state,
            'city' => $content->city,
            'postal_code' => $content->postal_code,
            'address' => $content->address,
        ]);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "آدرس ذخیره شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "آدرس ذخیره نشد"], 200);
        }
    }
    public function listAddress(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonAddress::where('person_id', '=', $person->person_id)->get();
        if ($result->count() > 0) {
            return response(['statusText' => 'ok', 'list' =>  $result], 200);
        } else {
            return response(['statusText' => 'ok', 'list' =>  null], 200);
        }
    }
    public function deleteAddress(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonAddress::where('person_id', '=', $person->person_id)->where('person_address_id', '=', $content->person_address_id)->delete();
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "آدرس حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "آدرس حذف نشد"], 200);
        }
    }
    public function addFavorite(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonFavorite::where([
            'person_id' => $person->person_id,
            'product_id' => $content->product_id

        ])->get();
        if ($result->count() == 0) {
            $result = PersonFavorite::create([
                'person_id' => $person->person_id,
                'product_id' => $content->product_id

            ]);
            if ($result) {
                return response(['statusText' => 'ok', 'message' => "کالا به علاقه مندی ها اضافه شد"], 200);
            } else {
                return response(['statusText' => 'fail',  'message' => "کالا به علاقه مندی ها اضافه نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "کالا به علاقه مندی ها اضافه شد"], 200);
    }
    public function deleteFavorite(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonFavorite::where([
            'person_id' => $person->person_id,
            'product_id' => $content->product_id

        ])->delete();
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "کالا از علاقه مندی ها حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail',  'message' => "کالا از علاقه مندی ها حذف نشد"], 200);
        }
    }
    public function favoriteList(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $result = PersonFavorite::where([
            'person_id' => $person->person_id,
        ])->get();
        $ids = [];
        foreach ($result as $item) {
            $ids[] = $item->product_id;
        }
        $result =  Product::where('product_id', '=', $ids)->get();
        foreach ($result as $product) {
            $product->productFullData();
        }
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $result], 200);
        } else {
            return response(['statusText' => 'fail',  'message' => "خطا در بازیابی اطلاعات"], 200);
        }
    }
    public function purchase(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $content =  json_decode($request->getContent());
            $person = G::getPersonFromToken($request->bearerToken());
            $result1 = Factor::create([
                'person_id' => $person->person_id,
                'person_address_id' => $content->person_address_id,
                'ref_id' => 1,
            ]);
            $result2 = UserCart::where('person_id', '=', $person->person_id)->get();
            foreach ($result2 as $product) {
                $product->product->productFullData();
                $temp = $product->product->toArray();
                $temp['number'] = $product->number;
                $temp['factor_id'] = $result1->factor_id;
                FactorProduct::create(G::getArrayItems($temp, (new FactorProduct)->getFillable()));
            };
            UserCart::where('person_id', '=', $person->person_id)->delete();
            return true;
        });
        if ($result) {
            return response(['statusText' => 'ok', 'message' => 'خرید انجام شد'], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => 'خرید انجام نشد'], 200);
        }
    }

    public function userFactors(Request $request)
    {
        $person = G::getPersonFromToken($request->bearerToken());
        $result = Factor::where([
            'person_id' => $person->person_id,
        ])->get();
        foreach ($result as $item1) {
            $temp = $item1->factorProducts;
            foreach ($temp as $item2) {
                $item2['time'] = $item1->created_at;
                $item2->product->productFullData();
            }
        }
        if ($result) {
            return response(['statusText' => 'ok', 'list' => $result], 200);
        } else {
            return response(['statusText' => 'fail',  'message' => "خطا در بازیابی اطلاعات"], 200);
        }
    }
    public function factorsList(Request $request)
    {
        $factors = Factor::all();
        foreach ($factors as $factor) {
            $factor->person->informations();
            $factor->address;
            $factor->factorProducts;
            foreach ($factor['factorProducts'] as $product) {
                $product->product->productFullData();
            }
        }
        if ($factors) {
            return response(['statusText' => 'ok', 'list' => $factors], 200);
        } else {
            return response(['statusText' => 'fail',  'message' => "خطا در بازیابی اطلاعات"], 200);
        }
    }
    public function changeFactorStatus(Request $request)
    {
        $content = json_decode($request->getContent());
        $result = Factor::where('factor_id' , '=' , $content->factor_id)->update(['status' => $content->status]);
        return response(['statusText' => 'ok', "message" => 'وضعیت فاکتور تغییر کرد'], 200);
    }
}
