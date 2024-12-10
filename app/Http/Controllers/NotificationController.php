<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications; // Mengambil semua notifikasi pengguna
        return view('notifications.index', compact('notifications'));
    }
}

