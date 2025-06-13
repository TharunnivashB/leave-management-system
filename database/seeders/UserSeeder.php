<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'vijaytharun658+admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Employee User
        $employee = User::firstOrCreate(
            ['email' => 'vijaytharun658+employee@gmail.com'],
            [
                'name' => 'Employee User',
                'password' => Hash::make('password'),
            ]
        );
        $employee->assignRole('employee');
    }
}
