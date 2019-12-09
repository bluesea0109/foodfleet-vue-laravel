<?php


namespace App\Http\Controllers\Foodfleet;

use App\Filters\BelongsToWhereInUuidEquals;
use App\Http\Controllers\Controller;
use App\Models\Foodfleet\Store;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Foodfleet\Store as StoreResource;
use App\Http\Resources\Foodfleet\StoreSummary as StoreSummaryResource;
use App\Http\Resources\Foodfleet\StoreServiceSummary as StoreServiceSummaryResource;
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
                'addresses',
                'events'
            ])
            ->allowedSorts([
                'name',
                'status',
                'created_at',
            ])
            ->allowedFilters([
                'name',
                Filter::exact('status'),
                Filter::custom('tag', BelongsToWhereInUuidEquals::class, 'tags'),
                Filter::exact('uuid'),
                Filter::exact('supplier_uuid')
            ]);

        return StoreResource::collection($stores->jsonPaginate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $uuid
     * @return StoreResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'status' => 'integer'
        ]);

        $inputs = $request->input();
        $store = Store::where('uuid', $uuid)->first();
        if ($store) {
            $store->update($inputs);
        }

        return new StoreResource($store);
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     * @return EventResource
     */
    public function show(Request $request, $uuid)
    {
        $store = QueryBuilder::for(Store::class, $request)
            ->where('uuid', $uuid)
            ->allowedIncludes([ 'menus', 'tags', 'menu_items', 'documents', 'messages' ])
            ->firstOrFail();

        return new StoreResource($store);
    }

    public function summary(Request $request, $uuid)
    {
        $store = QueryBuilder::for(Store::class, $request)
            ->with('tags')
            ->where('uuid', $uuid)
            ->firstOrFail();

        return new StoreSummaryResource($store);
    }

    public function serviceSummary(Request $request, $uuid)
    {
        $store = QueryBuilder::for(Store::class, $request)
            ->where('uuid', $uuid)
            ->firstOrFail();

        return new StoreServiceSummaryResource($store);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($uuid)
    {
        $store = Store::where('uuid', $uuid)->firstOrFail();
        $store->delete();
        return response()->json(null, SymfonyResponse::HTTP_NO_CONTENT);
    }
}
