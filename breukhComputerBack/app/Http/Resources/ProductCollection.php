<?php

namespace App\Http\Resources;

use App\Traits\HttpResp;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    use HttpResp;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->success(200,"",$this->collection);
    }
    public function paginationInformation($request, $paginated, $default)
    {
        return [
            "links" => $default["meta"]["links"]
        ];
    }
}
