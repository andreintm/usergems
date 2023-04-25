<?php

namespace App\Jobs;

use App\Services\UserCalendarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class RetrieveUserCalendarEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly User $user,
        private readonly bool $sentEmail = false,
    ){
    }

    /**
     * Execute the job.
     */
    public function handle(UserCalendarService $userCalendarService): void
    {
        $userCalendarService->sync($this->user);

        if ($this->sentEmail) {
            SendEmails::dispatch($this->user);
        }
    }
}
