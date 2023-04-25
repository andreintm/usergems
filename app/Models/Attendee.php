<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $avatar_url
 * @property mixed $linkedin_url
 * @property mixed $title
 * @property Company $company
 * @property mixed $id
 */
class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'avatar_url',
        'title',
        'linkedin_url',
        'company_id'
    ];

    public function user(): ?HasOne
    {
        return $this->hasOne(User::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'attendees_events')->withPivot('status');
    }

    public function company(): ?BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
