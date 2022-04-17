<?php

namespace App\Http\Middleware;

use App\Http\classes\G;
use Closure;
use Mockery\Matcher\Contains;
use Illuminate\Support\Str;

class CheckHeaders
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
        $headers = $request->headers->all();
        $allow_headers = ["content-type" => [
            "multipart/form-data",
            "application/json",
        ]];

        foreach ($headers as  $key => $value) {

            foreach ($allow_headers as  $lkey => $lvalue) {
                if ($key == $lkey) {
                    $bool = true;
                    foreach ($lvalue as  $lkey => $items) {
                        if (str_contains($value[0], $items)) {
                            $bool = false;
                        }
                    }
                    if ($bool) {
                        return response(['statusText' => 'fail', "meessage" => "header content-type most be application/json or multipart/form-data"], 406);
                    }
                }
            }
        }
        if ($request->header('content-type') == 'application/json' && !G::isJson($request->getContent())) {
            return response(['statusText' => 'fail', "meessage" => "content is not json"], 406);
        }
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

        return $response;
    }
}
