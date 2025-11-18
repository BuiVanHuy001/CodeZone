<?php

namespace App\Notifications\Instructor;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstructorRejectedNotification extends Notification {
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Instructor Application Rejected')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your application to become an instructor has been rejected.')
            ->line('If you have any questions or need further information, please feel free to contact our support team.')
            ->line('Thank you for your interest in joining our platform.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
