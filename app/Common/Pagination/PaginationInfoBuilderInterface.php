<?php

namespace App\Common\Pagination;


interface PaginationInfoBuilderInterface
{
    public function buildFrom(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator);
}
