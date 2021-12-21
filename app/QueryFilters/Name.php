<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Str;
class Name 
{
  

  public function handle($request, Closure $next)
  {

      if (!request()->has($this->filterName())) {
          return $next($request);
      }

      $builder = $next($request);
      return $builder->where($this->filterName(), 'like', '%'.request($this->filterName()).'%');
  }



  protected function filterName()
  {
      return Str::snake(class_basename($this));
  }
}
