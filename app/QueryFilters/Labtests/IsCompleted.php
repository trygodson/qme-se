<?php

namespace App\QueryFilters\Labtests;

use Closure;
use Illuminate\Support\Str;


    class IsCompleted
    {
        public function handle($request, Closure $next)
        {
            if (! request()->has('iscompleted')) {
                return $next($request);
            }

            return $next($request)->where('iscompleted', request()->input());
        }

       /*  protected function filterName()
        {
            return Str::snake(class_basename($this));
        } */
    }

    
