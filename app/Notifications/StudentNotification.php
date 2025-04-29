<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentNotification extends Notification
{
    use Queueable;

    protected $cicilan;

    /**
     * Create a new notification instance.
     */
    public function __construct($cicilan)
    {
        //
        $this->cicilan = $cicilan;

    }

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
            ->subject('Peringatan Jatuh Tempo Cicilan')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Anda memiliki cicilan yang akan jatuh tempo.')
            ->line('Nominal: Rp' . number_format($this->cicilan->cicilan, 0, ',', '.'))
            ->line('Tanggal Jatuh Tempo: ' . \Carbon\Carbon::parse($this->cicilan->tgl_jatuh_tempo)->format('d M Y'))
            ->action('Bayar Sekarang', url('https://newportal.unsada.ac.id/siakad/list_tagihanmhs')) // Link ke halaman bayar
            ->line('Segera lakukan pembayaran untuk menghindari denda.');
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
