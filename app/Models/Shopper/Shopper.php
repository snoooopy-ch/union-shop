<?php

namespace App\Models\Shopper;

use App\Models\Store\Location\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Shopper
 * @package App\Models\Shopper
 */
class Shopper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email',
        'status_id', 
        'location_id',
        'check_out'
    ];

    const ACTIVE        = 1;
    const COMPLETED     = 2;
    const PENDING       = 3;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeFilterLife($query, $expires)
    {
        return $query->where('check_in', '<', $expires);
    }

    public function scopeStatusId($query, $status)
    {
        return $query->where('status_id', $status);
    }

    public function scopeLocationId($query, $locationId) {
        return $query->where('location_id', $locationId);
    }
}
