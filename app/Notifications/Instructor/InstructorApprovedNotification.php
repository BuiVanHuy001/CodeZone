<?php

namespace App\Notifications\Instructor;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstructorApprovedNotification extends Notification {
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Instructor Application Has Been Approved')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your application to become an instructor on our platform has been approved.')
            ->line('You can now start creating and publishing courses to share your knowledge with our community.')
            ->line('Thank you for joining us as an instructor. We look forward to seeing the great content you will create!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
