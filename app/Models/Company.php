<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $employees
 * @property mixed $linkedin_url
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employees',
        'linkedin_url',
    ];

    public function attendees(): ?HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
