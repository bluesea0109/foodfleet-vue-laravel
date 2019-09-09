<?php

namespace Tests\Feature\Unit\Models\Item;

use App\Models\Foodfleet\Square\Category;
use App\Models\Foodfleet\Square\Item;
use App\Models\Foodfleet\Square\Payment;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testModel()
    {
        $category = factory(Category::class)->create();
        $payment = factory(Payment::class)->create();

        $item = factory(Item::class)->create();
        $item->category()->associate($category);
        $item->save();
        $item->payments()->sync([$payment->uuid]);

        $this->assertDatabaseHas('items', [
            'uuid' => $item->uuid,
            'category_uuid' => $category->uuid,
        ]);

        $this->assertDatabaseHas('payments_items', [
            'payment_uuid' => $payment->uuid,
            'item_uuid' => $item->uuid
        ]);
    }
}