<?php

namespace App\Http\Controllers;

use App\Http\classes\G;
use App\Http\Requests\logIn;
use App\Http\Requests\logOut;
use App\Models\Person;
use App\Models\Token;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Authentication extends Controller
{

    public function logIn(logIn $request)
    {
        $content =  json_decode($request->getContent());
        $person = Person::where('username', '=', G::changeWords($content->username))
            ->where('password', '=', G::getHash(G::changeWords($content->password)))->get();
        if ($person->count() == 1) {
            $person = $person[0];
            if ($person->status == 0) {
                return response(['status' => 'disabel'], 200);
            }
            $token = $person->token;
            $token = G::newToken($person->person_id, $token->token_id, 30)['token'];
            return response(['statusText' => 'ok', 'token' => $token], 200);
        }
        return response(['statusText' => 'fail'], 200);
    }
    public function logOut(logOut $request)
    {
        $content =  json_decode($request->getContent());
        $token = $content->token;
        Token::where('token', '=', $token)->update([
            'expiration' => G::timeNow(),
        ]);
        return response(['statusText' => 'ok'], 200);
    }
    public function register(Request $request)
    {
        $content =  json_decode($request->getContent());
        $person = Person::where('username', '=', G::changeWords($content->username))->get();
        if ($person->count() == 0) {
            $token = G::newToken(G::changeWords($content->username), -1, 90);
            $person = Person::create([
                'username' =>   G::changeWords($content->username),
                'password' =>  G::getHash(G::changeWords($content->password)),
                'role_id' =>  2,
                'token_id' =>  $token['token_id'],
                'status' =>  1,

            ]);
            if ($person->exists) {
                return response(['statusText' => 'ok', 'token' => $token['token']], 200);
            }
            return response(['statusText' => 'fail'], 201);
        }
        return response(['statusText' => 'fail', 'message' => 'نام کاربری وجود دارد'], 201);
    }

    public function checkToken()
    {
        return response(['statusText' => 'ok'], 200);
    }
}
