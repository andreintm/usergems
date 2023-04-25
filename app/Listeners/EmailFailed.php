<?php

namespace App\Listeners;

use App\Notifications\CalendarTickets;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Notifications\Events\NotificationFailed;
use Throwable;

readonly class EmailFailed
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private EmailRepositoryInterface $emailRepository
    ) {
    }

    /**
     * Handle the event.
     * @throws Throwable
     */
    public function handle(NotificationFailed $event): void
    {
        /** @var CalendarTickets $notification */
        $notification = $event->notification;

        $this->emailRepository->update($notification->getEmail(), [
            'failed_at' => now()
        ]);
    }
}
