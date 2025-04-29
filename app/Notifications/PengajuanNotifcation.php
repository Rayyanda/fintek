<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengajuanNotifcation extends Notification
{
    use Queueable;

    protected $pengajuan;
    protected $pengirim;
    /**
     * Create a new notification instance.
     */
    public function __construct($pengajuan, $pengirim)
    {
        //
        $this->pengajuan = $pengajuan;
        $this->pengirim = $pengirim;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'=>'Pengajuan Baru',
            'message'=>'Pengajuan Penundaan baru telah masuk',
            'pengirim'=>$this->pengirim,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Pengajuan Baru Masuk.')
            ->line('')
            ->action('Lihat', url('/dashboard'))
            ->line('Thank you for using our application!');
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
