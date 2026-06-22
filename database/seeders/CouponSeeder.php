<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'type' => 'percent',
                'value' => 10,
                'max_discount' => 500000,
                'min_order' => 1000000,
                'limit_usage' => 100,
                'used_count' => 0,
                'expiry_date' => now()->addYear()->toDateString(),
                'status' => 1,
            ]
        );
    }
}
