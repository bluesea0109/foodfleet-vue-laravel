<?php


namespace App\Models\Foodfleet;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;
use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Location
 *
 * @property int id
 * @property string uuid
 * @property string name
 * @property string spots
 * @property string capacity
 * @property string details
 * @property string venue_uuid
 * @property int category_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property string deleted_at
 *
 *
 * @property Event[} $events
 * @property Document[} documents
 * @property Venue venue
 * @property LocationCategory category
 *
 */
class Location extends Model
{
    use SoftDeletes;
    use GeneratesUuid;

    protected $guarded = ['id', 'uuid'];
    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->hasMany(Event::class, 'location_uuid', 'uuid');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'assigned', 'assigned_type', 'assigned_uuid', 'uuid');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_uuid', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(LocationCategory::class, 'category_id', 'id');
    }
}
