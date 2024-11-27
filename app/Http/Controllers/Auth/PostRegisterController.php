<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostRegisterController extends Controller
{
    public function index()
    {
        return view('auth.post-register');
    }

    public function update(Request $request)
    {

        $request->validate([
            'no_kk' => 'required',
            'no_wa' => 'required',
        ]);

        $user = User::find(Auth::id());

        $user->no_kk = $request->no_kk;
        $user->no_wa = $request->no_wa;

        $user->save();

        return redirect()->route('dashboard');
    }
}
