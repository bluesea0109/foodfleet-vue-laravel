<?php


namespace App\Http\Resources\Foodfleet\Store;

use FreshinUp\FreshBusForms\Http\Resources\Company\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Store extends JsonResource
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
            "status" => $this->status,
            "square_id" => $this->square_id,
            "supplier" => new Company($this->whenLoaded('supplier'))
        ];
    }
}
