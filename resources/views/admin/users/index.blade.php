<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.users.create-farmer') }}"
               class="bg-primary-600 border-2 border-transparent hover:border-accent-500 text-white font-semibold px-4 py-2 rounded-md text-sm transition">
                + Register Farmer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Tabs -->
                <div class="flex gap-2 mb-6 border-b">
                    @foreach (['farmer' => 'Farmers', 'buyer' => 'Buyers', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('admin.users.index', ['role' => $value]) }}"
                           class="px-4 py-2 text-sm font-medium border-b-2
                               {{ $role === $value ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                @if ($users->isEmpty())
                    <p class="text-gray-500">No users found.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2">Name</th>
                                <th class="py-2">Role</th>
                                <th class="py-2">Location</th>
                                <th class="py-2">Status</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-3">
                                        <a href="{{ route('admin.users.show', $user) }}" class="font-medium text-primary-600 hover:underline">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class="py-3 capitalize">{{ $user->role }}</td>
                                    <td class="py-3 text-gray-500">
                                        {{ $user->farmer->barangay ?? $user->buyer->barangay ?? '—' }}
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-block text-xs px-2 py-1 rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-right">
                                        <form method="POST" action="{{ route('admin.users.toggleActive', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs text-gray-500 hover:text-red-600 underline">
                                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>