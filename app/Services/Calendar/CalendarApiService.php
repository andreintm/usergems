<?php

namespace App\Services\Calendar;

use App\Services\Calendar\Interfaces\CalendarApiInterface;
use Illuminate\Support\Facades\Http;

readonly class CalendarApiService implements CalendarApiInterface
{
    public function __construct(
        private string $apiUrl
    ){
    }

    /**
     * @param string $apiKey
     * @param int $page
     * @return array
     */
    public function listEvents(string $apiKey, int $page = 1): array
    {
        return Http::withToken($apiKey)
            ->get($this->apiUrl, [
                'page' => $page
            ])
            ->json();
    }
}
