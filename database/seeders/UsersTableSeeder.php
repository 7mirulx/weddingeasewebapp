<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Sample Client',
            'role' => 'client',
            'email' => 'client@example.com',
            'phone' => '0123456789',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Sample Vendor',
            'role' => 'vendor',
            'email' => 'vendor@example.com',
            'phone' => '0198765432',
            'password' => Hash::make('password'),
        ]);
    }
}
