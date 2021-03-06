<?php

namespace App\Http\Resources\Foodfleet\Document\Template;

use FreshinUp\FreshBusForms\Http\Resources\User\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Template extends JsonResource {

    /**
     * @param \Illuminate\Http\Request
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'status_id' => $this->status_id,
            'status' => new Status($this->whenLoaded('status')),
            'updated_by' => new UserResource($this->whenLoaded('updatedBy')),
            'updated_by_uuid' => $this->updated_by_uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
