<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\Calendar\CalendarApiIterator;
use Illuminate\Support\Facades\Log;
use Exception;

readonly class UserCalendarService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private CalendarEventService $calendarEventService
    ){
    }

    public function sync(User $user): void
    {
        /** @var CalendarApiIterator $calendarApi */
        $calendarApi = app(CalendarApiIterator::class, [
            'apiKey' => $user->calendar_api_key
        ]);

        while ($calendarApi->valid()) {
            $calendarEventData = $calendarApi->current();

            if ($this->eventRepository->isNotChanged($user, $calendarEventData)) {
                Log::info('All events are up to date', [
                    'user' => $user->id
                ]);

                break;
            }

            try {
                $this->calendarEventService->save($user, $calendarEventData);
            } catch (Exception $exception) {
                Log::error($exception->getMessage(), [
                    'user' => $user->id,
                    'event_id' => $calendarEventData->id
                ]);
            }

            $calendarApi->next();
        }
    }
}
