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
            "id" => $this->id,
            "uuid" => $this->uuid,
            "name" => $this->name,
            "venue" => new Venue($this->whenLoaded('venue')),
            "venue_uuid" => $this->venue_uuid,
            "spots" => $this->spots,
            "capacity" => $this->capacity,
            "details" => $this->details,
            "category_id" => $this->category_id,
            "category" => new LocationCategory($this->whenLoaded('category')),
            "events" => Event::collection($this->whenLoaded('events')),
        ];
    }
}
