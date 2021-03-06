<?php

namespace App\Models\Foodfleet;

use App\Models\Model;

class EventType extends Model
{
    public $timestamps = false;
    public function events()
    {
        return $this->hasMany(Event::class, 'type_id');
    }
}
