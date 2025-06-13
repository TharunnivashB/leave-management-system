<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('leave_types')->insert([
            ['name' => 'Sick Leave', 'max_days_per_year' => 15, 'requires_approval' => true],
            ['name' => 'Casual Leave', 'max_days_per_year' => 12, 'requires_approval' => true],
            ['name' => 'Annual Leave', 'max_days_per_year' => 20, 'requires_approval' => true],
            ['name' => 'Unpaid Leave', 'max_days_per_year' => 365, 'requires_approval' => true],
        ]);
    }
}