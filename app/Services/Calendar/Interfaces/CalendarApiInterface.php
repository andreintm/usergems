<?php

namespace App\Services\Calendar\Interfaces;

interface
CalendarApiInterface
{
    public function listEvents(string $apiKey, int $page = 1): array;
}
