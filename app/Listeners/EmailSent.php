<?php

namespace App\Listeners;

use App\Notifications\CalendarTickets;
use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Notifications\Events\NotificationSent;
use Throwable;

readonly class EmailSent
{
    /**
     * @param EmailRepository $emailRepository
     */
    public function __construct(
        private EmailRepositoryInterface $emailRepository
    ) {
    }

    /**
     * Handle the event.
     * @throws Throwable
     */
    public function handle(NotificationSent $event): void
    {
        /** @var CalendarTickets $notification */
        $notification = $event->notification;

        $this->emailRepository->update($notification->getEmail(), [
            'sent_at' => now()
        ]);
    }
}
