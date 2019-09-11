<?php


namespace App\Models\Foodfleet\Square;

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
class PaymentType extends Model
{
    use SoftDeletes;
    use GeneratesUuid;

    protected $guarded = ['id', 'uuid'];
    protected $dates = ['deleted_at'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_type_uuid', 'uuid');
    }
}
