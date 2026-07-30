<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}