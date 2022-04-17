<?php

namespace App\Http\Middleware;

use App\Http\classes\G;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() == null) {
            return response(['statusText' => 'fail', "description" => "token is not set"], 406);
        }
        $token = $request->bearerToken();
        $routeName = Route::currentRouteName();


        $check = G::checkToken($token, true,  $routeName);
        if ($check['status'] == false) {
            return response(['statusText' => 'fail', "meessage" => $check['meessage']], 403);
        }
        if ($request->route()->getName() !=  $routeName) {
            return response(['statusText' => 'fail', "meessage" => "permission denid"], 403);
        }
        return $next($request);
    }
}
