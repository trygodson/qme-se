<?php

namespace App\QueryFilters\Labtests;

use Closure;
use Illuminate\Support\Str;


    class IsDoctorEnded
    {
        public function handle($request, Closure $next)
        {
            if (! request()->has('isdoctorended')) {
                return $next($request);
            }

            return $next($request)->where('isdoctorended', request()->input());
        }

       /*  protected function filterName()
        {
            return Str::snake(class_basename($this));
        } */
    }

    
