<?php

namespace App\Notifications;

use App\Models\MembershipRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipRequestReviewedNotification extends Notification
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
     * @return array
     */
    public function via(MembershipRequest $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(MembershipRequest $notifiable)
    {
        return (new MailMessage)
            ->subject($notifiable->isAccepted ? 'Selamat! Verifikasi Keanggotaan Diterima' : 'Maaf! Verifikasi Keanggotaan Ditolak')
            ->greeting($notifiable->isAccepted ? 'Selamat!' : 'Maaf!')
            ->line($notifiable->isAccepted ? 'Verifikasi keanggotaan Anda telah diterima. Selamat bergabung!' : 'Verifikasi keanggotaan Anda telah ditolak. Silakan hubungi kami untuk informasi lebih lanjut.')
            ->lineIf($notifiable->notes, 'Catatan: ' . $notifiable->notes)
            ->action('Lihat Detail', env('APP_URL') . '/membership');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray(MembershipRequest $notifiable)
    {
        return [
            //
        ];
    }
}
