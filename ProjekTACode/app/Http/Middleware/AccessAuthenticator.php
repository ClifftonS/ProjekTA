<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $access)
    {
        if($request->session()->get('clientAccess') != $access){
            $request->session()->flush();
            return response()->json(['redirect' => 'loginpage']);
        }
        return $next($request);
    }
}
