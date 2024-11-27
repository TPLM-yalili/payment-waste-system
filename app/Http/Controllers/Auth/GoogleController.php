<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            $existingUser = User::where('email', $google_user->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('dashboard');
            }

            $user = User::create([
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'google_id' => $google_user->getId(),
                'role' => 'user'
            ]);

            Auth::login($user);

            return redirect()->route('post-register');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong!');
        }
    }
}
