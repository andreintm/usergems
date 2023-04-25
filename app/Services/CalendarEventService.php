<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Services\Calendar\Data\Event as CalendarEventData;
use App\Services\Person\Interfaces\PersonApiInterface;
use App\Services\Calendar\Data\Person as CalendarPersonData;
use App\Repositories\AttendeeRepository;
use Exception;

readonly class CalendarEventService
{
    /**
     * @param EventRepository $eventRepository
     * @param AttendeeRepository $attendeeRepository
     * @param PersonApiInterface $personApi
     */
    public function __construct(
        private EventRepository $eventRepository,
        private AttendeeRepository $attendeeRepository,
        private PersonApiInterface $personApi,
    ) {
    }

    /**
     * @param User $user
     * @param CalendarEventData $calendarEventData
     * @return Event
     * @throws Exception
     */
    public function save(User $user, CalendarEventData $calendarEventData): Event
    {
        try {
            /** @var Event $event */
            $event = $this->eventRepository->updateOrCreate($user, $calendarEventData);
        } catch (Exception $exception) {
            throw new $exception;
        }

        /** @var CalendarPersonData $calendarPersonData */
        foreach ($calendarEventData->people as $calendarPersonData) {
            $personData = $this->personApi->getPerson($calendarPersonData->email);

             $this->attendeeRepository->updateOrCreate(
                $event,
                $personData,
                $calendarPersonData->status
            );
        }

        return $event;
    }
}
