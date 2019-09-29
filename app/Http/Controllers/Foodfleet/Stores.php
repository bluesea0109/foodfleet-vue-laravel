<?php


namespace App\Http\Controllers\Foodfleet;

use App\Http\Controllers\Controller;
use App\Models\Foodfleet\Store;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Foodfleet\Store as StoreResource;
use Spatie\QueryBuilder\Filter;
use App\Filters\Store\TagUuid as FilterTagUuid;

class Stores extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $stores = QueryBuilder::for(Store::class, $request)
            ->allowedIncludes([
                'tags',
                'address'
            ])
            ->allowedSorts([
                'name',
                'status',
                'created_at',
            ])
            ->allowedFilters([
                'name',
                Filter::exact('status'),
                Filter::exact('address_uuid'),
                Filter::custom('tag', FilterTagUuid::class),
            ]);

        return StoreResource::collection($stores->jsonPaginate());
    }
}
