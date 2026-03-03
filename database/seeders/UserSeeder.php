<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Novel',
                'username' => 'admin',
                'phone' => '081234567890',
                'role' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_subscribed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Novel',
                'username' => 'user',
                'phone' => '080987654321',
                'role' => 'member',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_subscribed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}