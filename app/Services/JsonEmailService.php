<?php

namespace App\Services;

use App\Interfaces\EmailServiceInterface;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use App\Repositories\AttendeeRepository;
use App\Repositories\Interfaces\AttendeeRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\EventRepository;

readonly class JsonEmailService implements EmailServiceInterface
{
    /**
     * @param EventRepository $eventRepository
     * @param AttendeeRepository $attendeeRepository
     */
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private AttendeeRepositoryInterface $attendeeRepository,
    ){
    }

    public function generate(User $user): array {

        $events = $this->eventRepository->byDate($user, today());

        $data = [];

        /** @var Event $event */
        foreach ($events as $event) {
            $data[] = [
                'start_at' => $event->start_at->format('h:i A'),
                'end_at' => $event->end_at->format('h:i A'),
                'length' => $event->start_at->shortAbsoluteDiffForHumans($event->end_at),
                'title' => $event->title,
                ...$this->getPeople($event)
            ];
        }

        return $data;
    }

    private function getPeople(Event $event): array
    {
        $colleagues = [];
        $joiners = [];

        /** @var Attendee $attendee */
        foreach ($event->attendees as $attendee) {

            if ($event->user->attendee->company->id === $attendee->company->id) {
                $colleagues[] = [
                    'first_name' => $attendee->first_name,
                    'last_name' => $attendee->last_name,
                    'status' => $attendee->pivot->status
                ];

                continue;
            }

            $joiners[] = [
                'first_name' => $attendee->first_name,
                'last_name' => $attendee->last_name,
                'avatar_url' => $attendee->avatar_url,
                'linkedin_url' => $attendee->linkedin_url,
                'title' => $attendee->title,
                'status' => $attendee->pivot->status,
                'total_meetings' => $this->attendeeRepository->totalMeetings($attendee, $event->user->attendee),
                'met_with' => $this->attendeeRepository->metWith($attendee, $event->user->attendee),
                'company' => [
                    'name' => $attendee->company->name,
                    'employees' => $attendee->company->employees,
                    'linkedin_url' => $attendee->company->linkedin_url
                ]
            ];

        }

        return [
            'colleagues' => $colleagues,
            'joiners' => $joiners
        ];
    }
}
