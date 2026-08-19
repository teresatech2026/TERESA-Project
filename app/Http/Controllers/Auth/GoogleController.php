<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after the user approves sign-in.
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if a user already exists with this Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            // Check if a user already exists with this email (e.g. registered normally before)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link the existing account to Google
                $user->update(['google_id' => $googleUser->getId()]);
            } else {
                // Brand new user — but we don't know their role (Farmer or Buyer) yet.
                // Send them to a short "finish registration" step instead of logging in directly.
                return redirect()->route('google.register', [
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                ]);
            }
        }

        if (! $user->is_active) {
            return redirect()->route('login')->withErrors([
                'email' => 'This account has been deactivated. Please contact the Municipal Agriculture Office.',
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Show the "finish registration" form for a brand-new Google user.
     */
    public function showRegisterForm(\Illuminate\Http\Request $request)
    {
        return view('auth.google-register', [
            'google_id' => $request->query('google_id'),
            'name' => $request->query('name'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Complete registration for a brand-new Google user (choosing role + extra fields).
     */
    public function completeRegistration(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'google_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:farmer,buyer',
            'mobile_number' => 'required|string|max:20',
            'barangay' => 'required|string|max:100',
            'sex' => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
        ]);

        $user = User::create([
            'username' => strtolower(str_replace(' ', '', $request->name)) . rand(100, 999),
            'name' => $request->name,
            'email' => $request->email,
            'google_id' => $request->google_id,
            'password' => bcrypt(\Illuminate\Support\Str::random(32)), // random, unused password since they'll always sign in via Google
            'role' => $request->role,
        ]);

        if ($request->role === 'farmer') {
            \App\Models\Farmer::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'sex' => $request->sex,
                'date_of_birth' => $request->date_of_birth,
                'mobile_number' => $request->mobile_number,
                'barangay' => $request->barangay,
            ]);
        } else {
            \App\Models\Buyer::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'mobile_number' => $request->mobile_number,
                'barangay' => $request->barangay,
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}