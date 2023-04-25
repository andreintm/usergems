<?php

namespace App\Notifications;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Throwable;

class CalendarTickets extends Notification //implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Email $email
    ){
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param object $notifiable
     * @return MailMessage
     * @throws Throwable
     */
    public function toMail(
        object $notifiable
    ): MailMessage {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->email->content;
    }
}
