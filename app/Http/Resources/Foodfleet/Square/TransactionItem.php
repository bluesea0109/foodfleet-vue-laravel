<?php


namespace App\Http\Resources\Foodfleet\Square;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItem extends JsonResource
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
            "name" => $this->name,
            "square_id" => $this->square_id,
            "quantity" => $this->pivot->quantity
        ];
    }
}
