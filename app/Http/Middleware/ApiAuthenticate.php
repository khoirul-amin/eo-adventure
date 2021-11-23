<?php

namespace App\Http\Middleware;

use App\Http\Library\ResponseLibrary;
use App\Http\Models\user_m;
use Closure;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;


class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        $url_get = explode("/", $request->getRequestUri());
        $url = end($url_get);

        if (!$request->header('apiKey') || $request->header('apiKey') != env('API_KEY')) {
            return response()->json((new ResponseLibrary())->res(301, null, 'Invalid Parameter Header'));
        }
        if ($url == "login" || $url == "register") {
            return $next($request);
        }

        // Cek Auth
        if(!$request->header('token')){
            return response()->json((new ResponseLibrary())->res(301, null, 'Invalid Parameter Header Token'));
        }
        
        $cek_login = user_m::where('id', $request->header('userId'))->first();
        if(!$cek_login){
            return response()->json((new ResponseLibrary())->res(301, null, 'UserID salah silahkan Login kembali'));
        }elseif($cek_login->token != $request->header('token')){
            return response()->json((new ResponseLibrary())->res(202, null, 'Sesi login habis silahkan login kembali'));
        }

        return $next($request);
    }
}
