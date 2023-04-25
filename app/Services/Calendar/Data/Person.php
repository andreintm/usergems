<?php

namespace App\Services\Calendar\Data;

use App\Enums\AttendeeStatus;
use Spatie\LaravelData\Data;

class Person extends Data
{
    public function __construct(
        public string $email,
        public AttendeeStatus $status
    ){
    }
}
