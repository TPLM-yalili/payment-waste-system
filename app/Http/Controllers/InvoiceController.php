<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use Carbon\Carbon;
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
        $invoices = Invoice::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->orderBy('due_date', 'desc')
            ->get();
        $isVerified = auth()->user()->is_verified;

        return view('dashboard', compact('invoices', 'isVerified'));
    }

    public function handleMidtransWebhook(Request $request)
    {
        Log::info('Midtrans Webhook Notification:', $request->all());

        $data = $request->json()->all();
        $transactionStatus = $data['transaction_status'];
        $orderId = $data['order_id'];

        $invoice = Invoice::where('order_id', $orderId)->first();

        if ($invoice) {
            switch ($transactionStatus) {
                case 'settlement':
                    $invoice->status = 'paid';
                    break;
                case 'pending':
                    $invoice->status = 'pending';
                    break;
                case 'cancel':
                case 'deny':
                case 'expired':
                    $invoice->status = 'failed';
                    break;
                default:
                    $invoice->status = 'unknown';
                    break;
            }
            $invoice->save();
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function payInvoice(Request $request, $invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            Log::error("Invoice tidak ditemukan: {$invoiceId}");
            return redirect()->route('invoice.index')->withErrors('Invoice tidak ditemukan');
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;

        $params = [
            'transaction_details' => [
                'order_id' => $invoice->order_id,
                'gross_amount' => $invoice->amount,
            ],
            'customer_details' => [
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
            ],
            'item_details' => [
                [
                    'id' => $invoice->order_id,
                    'price' => $invoice->amount,
                    'quantity' => 1,
                    'name' => 'Pembayaran Invoice #' . $invoice->order_id,
                ],
            ],
        ];

        try {
            Log::info('Mencoba membuat Snap Token', $params);
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

        $invoice->status = 'paid';
        $invoice->save();

        Notification::send($invoice->user, new PaymentSuccessNotification($invoice));

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
            return redirect()->route('dashboard')->with('error', 'Invoice tidak ditemukan.');
        }

        $invoice->status = 'paid';
        $invoice->save();

        $user = $invoice->user;
        if ($user) {
            $user->notify(new PaymentSuccessNotification($invoice));
        }

        return view('payment.success', compact('invoice'));
    }

    public function paymentPending(Request $request)
    {
        $orderId = $request->query('order_id');
        $invoice = Invoice::where('order_id', $orderId)->first();

        if ($invoice && $invoice->status === 'pending') {
            // Proses untuk memperbarui status invoice jika diperlukan
            $invoice->save();
        }

        return view('payment.pending', compact('invoice'));
    }

    public function paymentFailed()
    {
        return view('payment.failed');
    }

    public function showPendingPayment($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            abort(404, 'Invoice tidak ditemukan');
        }

        return view('payments.pending', compact('invoice'));
    }

    // Method to handle invoice generation command
    public function generateInvoices(Request $request)
    {
        // Get all users
        $users = User::all();

        // Validasi jika tidak ada pengguna yang terdaftar
        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'User tidak tersedia, tidak bisa membuat invoice.');
        }

        // Validasi jika invoice sudah dibuat bulan ini
        $lastInvoice = Invoice::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->first();

        if ($lastInvoice) {
            return redirect()->back()->with('error', 'Mohon maaf, Anda hanya bisa membuat invoice satu kali sebulan.');
        }

        foreach ($users as $user) {
            // Create a new invoice for each user
            Invoice::create([
                'user_id' => $user->id,
                'order_id' => 'INV-' . uniqid(),
                'amount' => 100000, // Amount for the invoice
                'due_date' => Carbon::now()->addMonth()->startOfMonth(),
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('admin.bills')->with('success', 'Invoice berhasil dibuat untuk semua pengguna.');
    }
}