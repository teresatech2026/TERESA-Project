<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:farmer,buyer',
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|lowercase|email|max:255|unique:'.User::class,
            'mobile_number' => 'required|string|max:20',
            'barangay' => 'required|string|max:100',
            'sex' => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => strtolower(str_replace(' ', '', $request->name)) . rand(100, 999),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}