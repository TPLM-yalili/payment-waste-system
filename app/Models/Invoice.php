<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Pastikan tidak ada properti `timestamps` yang diubah
    public $timestamps = true; // Ini secara default adalah true, tetapi pastikan ini tidak diubah

    // Kolom yang dapat diisi
    protected $fillable = [
        'user_id', 'order_id', 'amount', 'status', 'due_date', 'bulan'
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Event untuk otomatis mengisi kolom 'bulan'
    protected static function booted()
    {
        static::saving(function ($invoice) {
            if (!$invoice->created_at) {
                // Mengatur kolom 'bulan' berdasarkan 'created_at'
                $invoice->bulan = now()->format('Y-m-d');
            } else {
                $invoice->bulan = $invoice->created_at->format('Y-m-d');
            }
        });
    }
}