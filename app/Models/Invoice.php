<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',       // User yang terkait dengan invoice
        'order_id',      // ID pesanan
        'amount',        // Jumlah tagihan
        'status',        // Status pembayaran
        'due_date',      // Tanggal jatuh tempo
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
