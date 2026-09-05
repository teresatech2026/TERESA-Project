<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    /**
     * List all farmers and buyers (admins are managed separately via seeder).
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'farmer'); // default tab: farmers

        $users = User::whereIn('role', ['farmer', 'buyer'])
            ->when($role !== 'all', fn ($q) => $q->where('role', $role))
            ->with(['farmer', 'buyer'])
            ->latest()
            ->get();

        return view('admin.users.index', compact('users', 'role'));
    }

    /**
     * Show a single user's full profile.
     */
    public function show(User $user)
    {
        abort_unless(in_array($user->role, ['farmer', 'buyer']), 404);

        $user->load(['farmer.products', 'farmer.orders', 'buyer.orders']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Toggle a user's active/inactive status (Admin can suspend accounts).
     */
    public function toggleActive(User $user)
    {
        abort_unless(in_array($user->role, ['farmer', 'buyer']), 404);

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->is_active ? 'Account activated.' : 'Account deactivated.');
    }

    /**
     * Show the form for DA personnel to register a farmer in person.
     */
    public function createFarmer()
    {
        return view('admin.users.create-farmer');
    }

    /**
     * Save a new farmer account. The farmer provides their own details,
     * including their chosen password, to DA staff at the DA office;
     * DA staff types it in here on the farmer's behalf.
     */
    public function storeFarmer(Request $request)
    {
        $request->validate([
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
            'role' => 'farmer',
        ]);

        Farmer::create([
            'user_id' => $user->id,
            'full_name' => $request->name,
            'sex' => $request->sex,
            'date_of_birth' => $request->date_of_birth,
            'mobile_number' => $request->mobile_number,
            'barangay' => $request->barangay,
        ]);

        return redirect()->route('admin.users.index', ['role' => 'farmer'])
            ->with('success', 'Farmer account created successfully.');
    }
}