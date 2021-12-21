<?php

namespace App\QueryFilters;





class Isread extends Filter
{

  protected function applyFilter($builder) 
  {
    return $builder->where($this->filterName(),request($this->filterName()));
  }
}