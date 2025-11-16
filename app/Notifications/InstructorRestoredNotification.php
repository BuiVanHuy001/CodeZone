<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstructorRestoredNotification extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct() {}

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
            ->subject('Your Instructor Account Has Been Restored')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are pleased to inform you that your instructor account has been restored and is now active.')
            ->line('You can now log in and continue creating and managing your courses on our platform.')
            ->action('Log In to Your Account', url('/login'))
            ->line('If you have any questions or need assistance, please do not hesitate to contact our support team.')
            ->line('Thank you for being a valued member of our instructor community!');
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
