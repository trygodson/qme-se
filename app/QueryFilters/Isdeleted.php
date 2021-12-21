<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Str;

 class IsDeleted 
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