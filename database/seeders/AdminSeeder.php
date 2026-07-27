<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'username' => 'admin.vegetables',
            'name' => 'Grace Santelices',
            'email' => 'gracesantelices@gmail.com',
            'password' => Hash::make('Vegetables#2026'),
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'full_name' => 'Grace Santelices',
            'position' => 'Municipal Agriculturist',
            'area_of_responsibility' => 'Vegetable Crops',
            'contact_number' => '09171234567',
        ]);
    }
}