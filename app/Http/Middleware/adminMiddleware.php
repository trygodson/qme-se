<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       if (isset(Auth::user()->id)){
        if(Auth::user()->roles->id != 1){
            $message = "cannot perform this action";
            return response()->json($message, 400);
        }else{
        return $next($request);
        }
    }else{
        $message = "Unauthenticated";
        return response()->json($message, 400);
    }
    }
}
