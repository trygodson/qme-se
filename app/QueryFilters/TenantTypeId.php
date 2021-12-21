<?php

namespace App\QueryFilters;

class TenantTypeId extends Filter
{
    protected function applyFilter($builder)
    {
      return $builder->where($this->filterName(),request($this->filterName()));
    }
}
