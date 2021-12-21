<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class FilterOtpVerified
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Closure $next
    * @return mixed
    */
   public function handle($request, Closure $next)
   {

       $user = Auth::user();

       if (!$user->isVerified) {
         
        return response()->json(['error' => 'Email Not Verified'], 406);;
       }

       return $next($request);
   }
}