<?php

namespace Tests\Feature\Http\Controllers\Foodfleet\FinancialReports;

use App\Models\Foodfleet\FinancialModifier as Modifier;
use App\Models\Foodfleet\FinancialReport;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinancialReportTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function testGetList()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $reports = factory(FinancialReport::class, 5)->create([
            'user_id' => $user->id
        ]);

        $data = $this
            ->json('get', "/api/foodfleet/financial-reports")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertNotEmpty($data);
        $this->assertEquals(5, count($data));
        foreach ($reports as $idx => $report) {
            $this->assertArraySubset([
                'id' => $report->id,
                'name' => $report->name,
                'filters' => json_decode($report->filters, true),
                'created_at' => str_replace('"', '', json_encode($report->created_at)),
                'updated_at' => str_replace('"', '', json_encode($report->updated_at)),
            ], $data[$idx]);
        }
    }

    public function testGetListWithFilters()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        factory(FinancialReport::class, 5)->create([
            'name' => 'Not visibles',
            'user_id' => $user->id
        ]);

        $reportsToFind = factory(FinancialReport::class, 5)->create([
            'name' => 'To find',
            'user_id' => $user->id
        ]);

        $data = $this
            ->json('get', "/api/foodfleet/financial-reports")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertNotEmpty($data);
        $this->assertEquals(10, count($data));


        $data = $this
            ->json('get', "/api/foodfleet/financial-reports?filter[name]=find")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertNotEmpty($data);
        $this->assertEquals(5, count($data));

        foreach ($reportsToFind as $idx => $report) {
            $this->assertArraySubset([
                'id' => $report->id,
                'name' => $report->name,
                'filters' => json_decode($report->filters, true),
                'created_at' => str_replace('"', '', json_encode($report->created_at)),
                'updated_at' => str_replace('"', '', json_encode($report->updated_at)),
            ], $data[$idx]);
        }
    }

    public function testGetSingle()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this
            ->json('get', "/api/foodfleet/financial-reports/1")
            ->assertStatus(404);

        $modifier1 = factory(Modifier::class)->create();
        $modifier2 = factory(Modifier::class)->create();
        $report = factory(FinancialReport::class)->create([
            'modifier_1_id' => $modifier1->id,
            'modifier_2_id' => $modifier2->id
        ]);

        $data = $this
            ->json(
                'get',
                "/api/foodfleet/financial-reports/" . $report->id
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertArraySubset([
            'id' => $report->id,
            'name' => $report->name,
            'filters' => json_decode($report->filters, true),
            'modifier_1' => [
                'id' => $modifier1->id,
                'name' => $modifier1->name,
                'resource_name' => $modifier1->resource_name,
                'label' => $modifier1->label,
                'placeholder' => $modifier1->placeholder,
                'type' => $modifier1->type,
                'filter' => $modifier1->filter,
                'value_param' => $modifier1->value_param,
                'text_param' => $modifier1->text_param
            ],
            'modifier_2' => [
                'id' => $modifier2->id,
                'name' => $modifier2->name,
                'resource_name' => $modifier2->resource_name,
                'label' => $modifier2->label,
                'placeholder' => $modifier2->placeholder,
                'type' => $modifier2->type,
                'filter' => $modifier2->filter,
                'value_param' => $modifier2->value_param,
                'text_param' => $modifier2->text_param
            ],
            'created_at' => str_replace('"', '', json_encode($report->created_at)),
            'updated_at' => str_replace('"', '', json_encode($report->updated_at))
        ], $data);
    }

    public function testPost()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this
            ->json('post', "/api/foodfleet/financial-reports", [])
            ->assertStatus(422);

        $modifier1 = factory(Modifier::class)->create();
        $modifier2 = factory(Modifier::class)->create();
        $report = factory(FinancialReport::class)->make();
        $inputs = $report->toArray();
        $inputs['modifier_1_id'] = $modifier1->id;
        $inputs['modifier_2_id'] = $modifier2->id;
        $data = $this
            ->json('post', "/api/foodfleet/financial-reports", $inputs)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertDatabaseHas('financial_reports', [
            'name' => $report->name,
            'modifier_1_id' => $modifier1->id,
            'modifier_2_id' => $modifier2->id,
            'user_id' => $user->id
        ]);

        $this->assertArraySubset([
            'name' => $report->name,
            'modifier_1' => [
                'id' => $modifier1->id,
                'name' => $modifier1->name,
                'resource_name' => $modifier1->resource_name,
                'label' => $modifier1->label,
                'placeholder' => $modifier1->placeholder,
                'type' => $modifier1->type,
                'filter' => $modifier1->filter,
                'value_param' => $modifier1->value_param,
                'text_param' => $modifier1->text_param
            ],
            'modifier_2' => [
                'id' => $modifier2->id,
                'name' => $modifier2->name,
                'resource_name' => $modifier2->resource_name,
                'label' => $modifier2->label,
                'placeholder' => $modifier2->placeholder,
                'type' => $modifier2->type,
                'filter' => $modifier2->filter,
                'value_param' => $modifier2->value_param,
                'text_param' => $modifier2->text_param
            ],
            'filters' => json_decode($report->filters, true)
        ], $data);
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this
            ->json('put', "/api/foodfleet/financial-reports/1", [])
            ->assertStatus(404);

        $report = factory(FinancialReport::class)->create([
            'user_id' => $user->id
        ]);

        $this
            ->json('put', "/api/foodfleet/financial-reports/" . $report->id, [])
            ->assertStatus(422);

        $reportUpdate = factory(FinancialReport::class)->make();
        $modifier1 = factory(Modifier::class)->create();
        $modifier2 = factory(Modifier::class)->create();
        $inputs = $reportUpdate->toArray();
        $inputs['modifier_1_id'] = $modifier1->id;
        $inputs['modifier_2_id'] = $modifier2->id;

        $data = $this
            ->json('put', "/api/foodfleet/financial-reports/" . $report->id, $inputs)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertDatabaseHas('financial_reports', [
            'id' => $report->id,
            'name' => $reportUpdate->name,
            'modifier_1_id' => $modifier1->id,
            'modifier_2_id' => $modifier2->id,
        ]);

        $this->assertArraySubset([
            'id' => $report->id,
            'name' => $reportUpdate->name,
            'modifier_1' => [
                'id' => $modifier1->id,
                'name' => $modifier1->name,
                'resource_name' => $modifier1->resource_name,
                'label' => $modifier1->label,
                'placeholder' => $modifier1->placeholder,
                'type' => $modifier1->type,
                'filter' => $modifier1->filter,
                'value_param' => $modifier1->value_param,
                'text_param' => $modifier1->text_param
            ],
            'modifier_2' => [
                'id' => $modifier2->id,
                'name' => $modifier2->name,
                'resource_name' => $modifier2->resource_name,
                'label' => $modifier2->label,
                'placeholder' => $modifier2->placeholder,
                'type' => $modifier2->type,
                'filter' => $modifier2->filter,
                'value_param' => $modifier2->value_param,
                'text_param' => $modifier2->text_param
            ],
            'filters' => json_decode($reportUpdate->filters, true)
        ], $data);
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this
            ->json('delete', "/api/foodfleet/financial-reports/1", [])
            ->assertStatus(404);

        $report = factory(FinancialReport::class)->create([
            'user_id' => $user->id
        ]);

        $this
            ->json('delete', "/api/foodfleet/financial-reports/" . $report->id)
            ->assertStatus(204);

        $this->assertSoftDeleted('financial_reports', [
            'id' => $report->id,
            'name' => $report->name,
            'user_id' => $user->id
        ]);
    }
}
