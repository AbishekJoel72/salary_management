<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '9876543210',
            'password' => Hash::make('admin@123'),
            'configuration_password' => Hash::make('admin@123'),
            'role' => 'admin',
        ];
        DB::table('registrations')->insert($data);
    }
}
