<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $calendar_api_key
 * @property mixed $id
 * @property Attendee $attendee
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'calendar_api_key',
    ];

    /**
     * @return BelongsTo
     */
    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }
}
