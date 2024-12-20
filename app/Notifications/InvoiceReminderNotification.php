<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceReminderNotification extends Notification
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
                    ->subject('Pengingat Pembayaran Tagihan')
                    ->line('Tagihan Anda dengan Order ID ' . $this->invoice->order_id . ' masih belum dibayar.')
                    ->action('Bayar Sekarang', url('/invoice/' . $this->invoice->id . '/pay'))
                    ->line('Harap segera melakukan pembayaran sebelum tanggal jatuh tempo.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'message' => 'Pengingat pembayaran untuk tagihan ' . $this->invoice->order_id . ' yang belum dibayar.',
        ];
    }
}
