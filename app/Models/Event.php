<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $title
 * @property Collection<Attendee> $attendees
 * @property User $user
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'start_at',
        'end_at',
        'changed_at'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(Attendee::class, 'attendees_events')->withPivot('status');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
