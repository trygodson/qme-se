<?php

namespace App\QueryFilters\Doctor;
use Illuminate\Support\Str;
use Closure;

class Availability
{


    public function handle($request, Closure $next)
    {
  
        if (!request()->has($this->filterName())) {
            return $next($request);
        }
  
        $builder = $next($request);
        return $builder->where($this->filterName(),request($this->filterName()));
    }
  
  
  
    protected function filterName()
    {
        return Str::snake(class_basename($this));
    }
 
  }