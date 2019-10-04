<?php

namespace App;

use App\Models\Foodfleet\FinancialReport;
use App\Models\Foodfleet\Document;

class User extends \FreshinUp\FreshBusForms\Models\User\User
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data_visibility' => 'array'
    ];

    public function financialReports()
    {
        return $this->hasMany(FinancialReport::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'assigned', 'assigned_type', 'assigned_uuid', 'uuid');
    }
}
