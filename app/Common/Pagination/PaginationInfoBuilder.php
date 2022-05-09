<?php

namespace App\Common\Pagination;


class PaginationInfoBuilder implements PaginationInfoBuilderInterface
{
    private $offset;
    private $count;

    public function buildFrom($paginator)
    {
        return [
            "page" => $paginator->currentPage(),
            "total_pages" => $paginator->lastPage(),
            "total_users" => $paginator->total(),
            "count" => $this->getCount(),
            "links" => $this->buildLinks($paginator),
        ];
    }

    private function buildLinks($paginator)
    {
        return [
            'next_url' => $this->buildLink($paginator->nextPageUrl()),
            'prev_url' => $this->buildLink($paginator->previousPageUrl()),
        ];
    }

    private function buildLink($link)
    {
        if($link)
        {
            if($this->getCount())
            {
                $link .= '&count='. $this->getCount();
            }

            if($this->getOffset())
            {
                $link .= '&offset='. $this->getOffset();
            }
        }

        return $link;
    }

    public function getOffset()
    {
        return $this->offset;
    }
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }
}
