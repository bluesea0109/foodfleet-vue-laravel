<?php


namespace App\Http\Resources\Foodfleet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Location extends JsonResource
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
            "venue" => new Venue($this->whenLoaded('venue')),
            "spot" => $this->spots,
            "capacity" => $this->capacity,
            "details" => $this->details

        ];
    }
}
