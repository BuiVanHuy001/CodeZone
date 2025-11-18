<?php

namespace App\Notifications\Course;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseSuspendedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Course $course,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Course Has Been Suspended')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your course "' . $this->course->title . '" has been suspended due to a violation of our terms of service.')
            ->line('If you believe this is a mistake or would like more information, please contact our support team.')
            ->line('Thank you for your understanding.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
