<?php

namespace App\Notifications;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipExpiryReminder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(Membership $notifiable)
    {
        $isExpired = $notifiable->period_end->isPast();
        $mailMessage = $isExpired
            ? (new MailMessage)
            ->subject("[ACTION REQUIRED] Masa keanggotaan telah berakhir")
            ->line("Masa keanggotaan Anda telah berakhir pada {$notifiable->period_end->locale('id')->translatedFormat('j F Y')}.")
            : (new MailMessage)
            ->subject("[ACTION REQUIRED] Masa keanggotaan tersisa {$notifiable->period_end->diffInDays()} hari lagi")
            ->line("Masa keanggotaan Anda akan berakhir pada {$notifiable->period_end->locale('id')->translatedFormat('j F Y')}.");

        return $mailMessage
            ->greeting("Yth. {$notifiable->name}")
            ->line('Silakan perpanjang keanggotaan Anda sebelum masa keanggotaan berakhir.')
            ->action('Perpanjang Keanggotaan', env('APP_URL') . '/membership');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
