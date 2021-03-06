<?php


namespace App\Http\Controllers\Foodfleet;

use App\Http\Controllers\Controller;
use App\Models\Foodfleet\Square\Payment;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Foodfleet\Square\Payment as PaymentResource;

class Payments extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $payments = QueryBuilder::for(Payment::class, $request)
            ->allowedFilters([
                Filter::exact('uuid'),
                'square_id'
            ]);

        return PaymentResource::collection($payments->jsonPaginate());
    }
}
