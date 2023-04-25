<?php

namespace App\Console\Commands;

use App\Jobs\RetrieveUserCalendarEvents;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Throwable;

class CalendarEvents extends Command
{
    const SENT_EMAIL_AT = '8:00';
    const USER_CHUNK_RECORDS = 100;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calendar-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve calendar events and send emails at 8AM';

    /**
     * Execute the console command.
     * @throws Throwable
     */
    public function handle(UserRepositoryInterface $userRepository): void
    {
        $sentEmail = now()->is(self::SENT_EMAIL_AT);

        $userRepository->chunk(self::USER_CHUNK_RECORDS, function (Collection $users) use ($sentEmail) {
            foreach ($users as $user) {
                RetrieveUserCalendarEvents::dispatch($user, $sentEmail);
            }
        });
    }
}
