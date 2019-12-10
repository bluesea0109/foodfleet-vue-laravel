<?php


namespace App\Http\Controllers\Foodfleet;

use App\Actions\UpdateStore;
use App\Filters\BelongsToWhereInUuidEquals;
use App\Http\Controllers\Controller;
use App\Models\Foodfleet\Event;
use App\Models\Foodfleet\Store;
use App\Actions\UpdateDocument;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Foodfleet\Store\Store as StoreResource;
use App\Http\Resources\Foodfleet\Store\StoreSummary as StoreSummaryResource;
use App\Http\Resources\Foodfleet\Store\StoreServiceSummary as StoreServiceSummaryResource;
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
            'status' => 'integer',
            'commission_rate' => 'integer',
            'commission_type' => 'integer',
            'event_uuid' => 'string|exists:events,uuid'
        ]);

        $inputs = $request->input();
        $collection = collect($inputs);
        $updateData = $collection->except(['event_uuid', 'commission_rate', 'commission_type'])->all();
        $store = Store::where('uuid', $uuid)->first();
        if ($store) {
            $store->update($updateData);
        }

        $event_uuid = $collection->get('event_uuid');
        $commission_rate = $collection->get('commission_rate');
        $commission_type = $collection->get('commission_type');
        if (!empty($event_uuid) && !empty($commission_rate) && !empty($commission_type)) {
            $event = Event::where('uuid', $event_uuid)->first();
            $store->events()->updateExistingPivot($event, ['commission_rate' => $commission_rate, 'commission_type' => $commission_type]);
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
            ->allowedIncludes([ 'menus', 'tags', 'documents', 'events' ])
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
            ->with('events')
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
