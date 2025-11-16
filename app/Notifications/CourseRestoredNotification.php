<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseRestoredNotification extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Course $course,
    ) {}

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
        return (new MailMessage)
            ->subject('Course Restored Successfully')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are pleased to inform you that your course "' . $this->course->title . '" has been successfully restored.')
            ->line('You can now access and manage your course as usual.')
            ->line('Thank you for being a valued member of our community!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
