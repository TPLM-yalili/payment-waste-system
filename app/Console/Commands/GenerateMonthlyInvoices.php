<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Invoice;
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Hasilkan faktur bulanan untuk semua pengguna berdasarkan no_kk mereka';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::where('is_verified', true)->get(); // Ambil semua user yang sudah terverifikasi

        foreach ($users as $user) {
            Invoice::create([
                'user_id' => $user->id,
                'order_id' => 'INV-' . uniqid(),
                'amount' => 30000, // Nominal tagihan
                'due_date' => Carbon::now()->addMonth()->startOfMonth(),
            ]);
        }

        $this->info('Tagihan bulanan sukses untuk dikirimkan ke pengguna yang terdaftar!');
    }
}