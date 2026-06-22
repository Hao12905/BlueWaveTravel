<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TourSeeder::class,
            CouponSeeder::class,
        ]);

        $accounts = [
            [
                'name' => 'BlueWave Admin',
                'full_name' => 'Quản trị viên BlueWave',
                'email' => 'admin@bluewave.test',
                'role' => 2,
            ],
            [
                'name' => 'BlueWave Manager',
                'full_name' => 'Quản lý BlueWave',
                'email' => 'manager@bluewave.test',
                'role' => 1,
            ],
            [
                'name' => 'BlueWave Customer',
                'full_name' => 'Khách hàng Demo',
                'email' => 'customer@bluewave.test',
                'role' => 0,
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                $account + [
                    'password' => Hash::make('password'),
                    'phone' => '0900000000',
                    'points' => 0,
                    'status' => 1,
                ]
            );
        }
    }
}
