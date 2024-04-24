<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{

    public function handle(Request $request, Closure $next): Response
    {

    if(auth()->guard('user')->check() )
        return $next($request);
    else
        // return response()->josn(['message'=>'unauthrized '],403);
         abort(403);
  }
}
