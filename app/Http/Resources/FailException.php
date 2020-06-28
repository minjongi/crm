<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FailException extends JsonResource
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
            'status' => 'fail',
            'data' => [
                'code' => $this->resource->getCode(),
                'message' => $this->resource->getMessage()
            ]
        ];
    }
}
