<?php

namespace App\Notifications\Course;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseApprovedNotification extends Notification
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
            ->subject('Your Course Has Been Approved! 🎉')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your course "' . $this->course->title . '" has been approved and is now live on the platform.')
            ->line('Students can now start enrolling and learning from your course.')
            ->action('View Course', route('page.course_detail', $this->course->slug))
            ->line('Thank you for being part of our teaching community!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
