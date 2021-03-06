<?php


namespace App\Models\Foodfleet;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EventTag
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 *
 * @property Event[] events
 */
class EventTag extends Model
{
    use SoftDeletes;
    use GeneratesUuid;

    protected $guarded = ['id', 'uuid'];
    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'events_event_tags',
            'event_tag_uuid',
            'event_uuid',
            'uuid',
            'uuid'
        );
    }
}
