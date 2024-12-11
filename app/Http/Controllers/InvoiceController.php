<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentSuccessNotification;
use App\Notifications\InvoiceReminderNotification;


class InvoiceController extends Controller
{
    public function index()
    {
        // Mengambil invoice yang belum dibayar (pending) untuk user yang sedang login
        $invoices = Invoice::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->orderBy('due_date', 'desc')
            ->get();

        return view('dashboard', compact('invoices'));
    }

    public function handleMidtransWebhook(Request $request)
    {
        // Log incoming notification for debugging
        Log::info('Midtrans Webhook Notification:', $request->all());

        // Parse the notification data
        $data = $request->json()->all();

        // Check the transaction status
        $transactionStatus = $data['transaction_status'];
        $orderId = $data['order_id'];

        // Find the invoice by order ID
        $invoice = Invoice::where('order_id', $orderId)->first();

        if ($invoice) {
            // Update the invoice status based on the transaction status
            switch ($transactionStatus) {
                case 'settlement':
                    // Mark as paid if the payment is successful
                    $invoice->status = 'paid';
                    $invoice->save();
                    break;
                case 'pending':
                    // Mark as pending if the payment is still being processed
                    $invoice->status = 'pending';
                    $invoice->save();
                    break;
                case 'cancel':
                case 'deny':
                case 'expired':
                    // Mark as failed if the payment was canceled, denied, or expired
                    $invoice->status = 'failed';
                    $invoice->save();
                    break;
                default:
                    // Handle any other transaction status
                    $invoice->status = 'unknown';
                    $invoice->save();
                    break;
            }
        }

        // Send a 200 OK response to Midtrans
        return response()->json(['status' => 'success'], 200);
    }

    public function payInvoice(Request $request, $invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            Log::error("Invoice tidak ditemukan: {$invoiceId}");
            return redirect()->route('invoice.index')->withErrors('Invoice tidak ditemukan');
        }

        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;

        $transactionDetails = [
            'order_id' => $invoice->order_id,
            'gross_amount' => $invoice->amount,
        ];

        $customerDetails = [
            'first_name' => $invoice->user->name,
            'email' => $invoice->user->email,
            'phone' => $invoice->user->phone,
            'billing_address' => [
                'first_name' => $invoice->user->name,
                'address' => $invoice->billing_address,
                'city' => $invoice->city,
                'postal_code' => $invoice->postal_code,
                'phone' => $invoice->user->phone,
            ],
        ];

        $itemDetails = [
            [
                'id' => $invoice->order_id,
                'price' => $invoice->amount,
                'quantity' => 1,
                'name' => 'Pembayaran Invoice #' . $invoice->order_id,
            ],
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            Log::info('Mencoba membuat Snap Token');
            // Log data yang dikirim ke Midtrans
            Log::info('Data transaksi:', $params);

            // Mengambil Snap Token
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token berhasil dibuat: ' . $snapToken);

            return view('payment.page', compact('snapToken', 'invoice'));
        } catch (\Exception $e) {
            Log::error('Gagal membuat Snap Token: ' . $e->getMessage());
            return redirect()->route('dashboard')->withErrors('Gagal memproses transaksi.');
        }
    }

    public function updatePaymentStatus(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        // Simulasi update status invoice setelah pembayaran
        $invoice->status = 'paid';
        $invoice->save();

        // Kirim notifikasi pembayaran berhasil
        Notification::send($invoice->user, new PaymentSuccessNotification($invoice));

        // Redirect ke halaman sukses pembayaran
        return redirect()->route('payment.success')->with('success', 'Pembayaran berhasil!');
    }

    public function remindPendingInvoices()
    {
        $pendingInvoices = Invoice::where('status', 'pending')->get();

        foreach ($pendingInvoices as $invoice) {
            Notification::send($invoice->user, new InvoiceReminderNotification($invoice));
        }

        return back()->with('success', 'Pengingat tagihan telah dikirim.');
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $invoice = Invoice::where('order_id', $orderId)->first();

        if (!$invoice) {
            return redirect()->route('dashboard')->with('error', 'Invoice not found.');
        }

        // Update the status to 'paid'
        $invoice->status = 'paid';
        $invoice->save();

        $user = $invoice->user; // Pastikan ada relasi 'user' di model Invoice
        if ($user) {
            $user->notify(new PaymentSuccessNotification($invoice));
        }


        return view('payment.success', compact('invoice'));
    }

    public function paymentPending(Request $request)
    {
        $orderId = $request->query('order_id');
        $invoice = Invoice::where('order_id', $orderId)->first();

        return view('dashboard', compact('invoice'));
    }

    public function paymentFailed()
    {
        // Tampilkan halaman jika pembayaran gagal
        return view('payment.failed');  // Sesuaikan dengan view yang kamu inginkan
    }

}
