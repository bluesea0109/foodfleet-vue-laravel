<?php


namespace App\Models\Foodfleet;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PaymentType
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 */
class StoreTag extends Model
{
    use SoftDeletes;
    use GeneratesUuid;

    protected $guarded = ['id', 'uuid'];
    protected $dates = ['deleted_at'];

    public function stores()
    {
        return $this->belongsToMany(
            Store::class,
            'stores_store_tags',
            'store_tag_uuid',
            'store_uuid',
            'uuid',
            'uuid'
        );
    }
}
