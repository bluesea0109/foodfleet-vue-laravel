<?php


namespace App\Models\Foodfleet\Square;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Device
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
class Device extends Model
{
    use SoftDeletes;
    use GeneratesUuid;

    protected $guarded = ['id', 'uuid'];
    protected $dates = ['deleted_at'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'device_uuid', 'uuid');
    }
}
