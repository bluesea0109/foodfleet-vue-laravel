<?php

namespace App\Http\Controllers\Foodfleet;

use App\Http\Resources\Foodfleet\Store\StoreStatus as StoreStatusResource;
use App\Models\Foodfleet\StoreStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class StoreStatuses extends Controller
{
    public function index(Request $request)
    {
        $storeStatuses = QueryBuilder::for(StoreStatus::class, $request)
            ->allowedFilters(['name'])
            ->get();

        return StoreStatusResource::collection($storeStatuses);
    }
}
