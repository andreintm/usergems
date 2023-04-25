<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $content
 */
class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'sent_at'
    ];

    protected $casts = [
        'content' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
