<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewTicketNotification extends Notification
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info('Sending email to: ' . $notifiable->email);

        return (new MailMessage)
            ->line('Un nouveau ticket a été créé.')
            ->line('ID du ticket: ' . $this->ticket->id)
            ->line('Objet: ' . $this->ticket->object)
            ->line('Catégorie de problème: ' . $this->ticket->problemCategory->name)
            ->line('Application: ' . $this->ticket->application->app_name)
            ->action('Voir le ticket', url('/tickets/' . $this->ticket->id))
            ->line('Merci de prendre en charge ce ticket dès que possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'object' => $this->ticket->object,
            'problem_category' => $this->ticket->problemCategory->name,
            'application' => $this->ticket->application->app_name,
        ];
    }
}
