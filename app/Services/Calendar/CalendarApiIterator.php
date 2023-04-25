<?php

namespace App\Services\Calendar;

use App\Services\Calendar\Data\Event;
use App\Services\Calendar\Interfaces\CalendarApiInterface;
use Iterator;

class CalendarApiIterator implements Iterator
{
    private int $currentPage = 1;
    private int $position = 0;
    private array $data = [];
    private int $perPage = 0;

    public function __construct(
        private readonly string $apiKey,
        private readonly CalendarApiInterface $calendarApi,
    ) {
        $this->getData();
    }

    public function current(): Event
    {
        return Event::from(
            $this->data[$this->position]
        );
    }

    public function next(): void
    {
        $this->position++;

        if ($this->position >= $this->perPage) {
            $this->currentPage++;
            $this->position = 0;

            $this->getData();
        }
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return array_key_exists($this->position, $this->data);
    }

    public function rewind(): void
    {
        $this->currentPage = 1;
        $this->position = 0;

        $this->getData();
    }

    private function getData(): void
    {
        $response = $this->calendarApi->listEvents($this->apiKey, $this->currentPage);

        $this->perPage = $response['per_page'];
        $this->data = $response['data'];
    }
}
