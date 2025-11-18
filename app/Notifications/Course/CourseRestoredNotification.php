<?php

namespace App\Notifications\Course;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseRestoredNotification extends Notification {
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
            ->subject('Course Restored Successfully')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are pleased to inform you that your course "' . $this->course->title . '" has been successfully restored.')
            ->line('You can now access and manage your course as usual.')
            ->line('Thank you for being a valued member of our community!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
