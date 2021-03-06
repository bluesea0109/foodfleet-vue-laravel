<?php


namespace App\Http\Resources\Foodfleet\Square;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "square_id" => $this->square_id
        ];
    }
}
