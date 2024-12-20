<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];  // Kita akan menggunakan email dan database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pembayaran Sukses')
                    ->line('Pembayaran Anda untuk tagihan ' . $this->invoice->order_id . ' telah berhasil.')
                    ->action('Lihat Tagihan', url('/dashboard'))
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'message' => 'Pembayaran berhasil untuk tagihan ' . $this->invoice->order_id,
        ];
    }
}
