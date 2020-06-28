<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 'success',
            'data' => $this->collection
        ];
    }

    public function setCollectResource($collects=null)
    {
        $this->collection = $collects && ! $this->resource->first() instanceof $collects
            ? $this->resource->mapInto($collects)
            : $this->resource->toBase();

        $this->resource = $this->resource instanceof AbstractPaginator
            ? $this->resource->setCollection($this->collection)
            : $this->collection;

        return $this;
    }
}
