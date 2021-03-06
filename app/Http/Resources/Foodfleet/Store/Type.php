<?php

namespace App\Http\Resources\Foodfleet\Store;

use Illuminate\Http\Resources\Json\JsonResource;

class Type extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->id,
            'name' => $this->name,
            'text' => $this->name
        ];
    }
}
