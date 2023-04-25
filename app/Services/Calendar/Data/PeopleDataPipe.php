<?php

namespace App\Services\Calendar\Data;

use App\Enums\AttendeeStatus;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataPipes\DataPipe;
use Spatie\LaravelData\Support\DataClass;

class PeopleDataPipe implements DataPipe
{

    public function handle(mixed $payload, DataClass $class, Collection $properties): Collection
    {
        $people = [];

        foreach ($payload['accepted'] as $person) {
            $people[] = [
                'email' => $person,
                'status' => AttendeeStatus::ACCEPTED
            ];
        }

        foreach ($payload['rejected'] as $person) {
            $people[] = [
                'email' => $person,
                'status' => AttendeeStatus::REJECTED
            ];
        }

        unset($payload['accepted'], $payload['rejected']);

        $payload['people'] = $people;

        return collect($payload);
    }
}
