<?php

namespace App\Jobs;

use App\Interfaces\EmailServiceInterface;
use App\Models\Email;
use App\Models\User;
use App\Notifications\CalendarTickets;
use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\JsonEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly User $user
    ){
    }

    /**
     * @param UserRepository $userRepository
     * @param EmailRepository $emailRepository
     * @param JsonEmailService $emailService
     * @return void
     */
    public function handle(
        UserRepositoryInterface $userRepository,
        EmailRepositoryInterface $emailRepository,
        EmailServiceInterface $emailService,
    ): void {
        if ($userRepository->hasEmailSent($this->user)) {
            return;
        }

        $content = $emailService->generate($this->user);

        /** @var Email $email */
        $email = $emailRepository->save(
            $this->user, [
                'content' => $content
            ]
        );

        $this->user->notify(
            new CalendarTickets($email)
        );
    }
}
