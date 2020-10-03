<?php

namespace App\Http\Controllers\Foodfleet\Document\Template;

use App\Http\Resources\Foodfleet\Document\Template\Template as Resource;
use App\Models\Foodfleet\Document\Template\Template as Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class Templates extends Controller
{
    public function index(Request $request)
    {
        $templates = QueryBuilder::for(Model::class, $request)
            ->allowedFilters([
                'title',
                'type_id',
                'status_id',
                'updated_at',
            ])
            ->allowedIncludes([
                'type',
                'status',
            ])
            ->allowedSorts([
                'type_id',
                'status_id',
                'updated_at',
            ])
            ->get();

        return Resource::collection($templates);
    }

    public function show(Request $request, $uuid)
    {
        $template = QueryBuilder::for(Model::class, $request)
            ->where('uuid', $uuid)
            ->allowedIncludes([
                'type',
                'status',
            ])
            ->firstOrFail();

        return new Resource($template);
    }

    public function update(Request $request, $uuid)
    {
        $item = Model::where('uuid', $uuid)->firstOrFail();
        $rules = [
            'title' => 'string',
            'status_id' => 'exists:document_template_statuses,id',
            'type_id' => 'exists:document_template_types,id',
        ];
        $payload = $request->only(array_keys($rules));
        $item->update($payload);
        return new Resource($item);
    }

    public function destroy($uuid)
    {
        $item = Model::where('uuid', $uuid)->firstOrFail();
        $item->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
