<?php

namespace Tests\Feature\Http\Resources\Foodfleet;

use App\Enums\VenueStatus as VenueStatusEnum;
use App\Http\Resources\Foodfleet\VenueStatus as VenueStatusResource;
use App\Models\Foodfleet\VenueStatus as VenueStatusModel;
use Illuminate\Http\Request;
use Tests\TestCase;

class VenueStatusTest extends TestCase {


    public function getDataProvider () {
        return [
            [VenueStatusEnum::PENDING, 'grey'],
            [VenueStatusEnum::APPROVED, 'success'],
            [VenueStatusEnum::REJECTED, 'error'],
            [VenueStatusEnum::EXPIRING, 'warning'],
            [VenueStatusEnum::EXPIRED, 'error']
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @param $id
     * @param $color
     */
    public function testResource ($id, $color) {
        $venueStatus = factory(VenueStatusModel::class)->make([
            'id' => $id
        ]);
        $resource = new VenueStatusResource($venueStatus);
        $expected = [
            'id' => $id,
            'name' => $venueStatus->name,
            'color' => $color
        ];
        $request = app()->make(Request::class);
        $result = $resource->toArray($request);
        $this->assertArraySubset($expected, $result);
    }
}
