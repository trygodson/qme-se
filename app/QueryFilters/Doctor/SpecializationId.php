<?php

namespace App\QueryFilters\Doctor;


use Closure;
use Illuminate\Support\Str;

class SpecializationId 
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