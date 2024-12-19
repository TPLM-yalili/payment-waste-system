<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Invoice;
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate monthly invoices for all users based on their no_kk';

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
                'amount' => 100000, // Nominal tagihan
                'due_date' => Carbon::now()->addMonth()->startOfMonth(),
            ]);
        }

        $this->info('Monthly invoices have been generated successfully!');
    }
}
