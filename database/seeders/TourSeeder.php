<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourSeeder extends Seeder
{
    public function run()
    {
        // 1. Tắt kiểm tra ràng buộc khóa ngoại tạm thời
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Tiến hành xóa sạch dữ liệu cũ một cách an toàn
        DB::table('tours')->truncate();

        // 3. Bật lại kiểm tra ràng buộc khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Tiến hành nạp dữ liệu mượt mà
        DB::table('tours')->insert([
            [
                'title' => 'Tour Vịnh Hạ Long - Đảo Tuần Châu Luxury',
                'description' => 'Khám phá kỳ quan thiên nhiên thế giới trên du thuyền 5 sao đẳng cấp, thưởng thức hải sản thượng hạng.',
                'image_url' => 'halong.jpg',
                'price' => 3500000,
                'departure_date' => '2026-06-15',
                'featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tour Đảo Ngọc Phú Quốc - Ngắm Hoàng Hôn Sunset Sanato',
                'description' => 'Trải nghiệm cáp treo hòn Thơm dài nhất thế giới, lặn ngắm san hô và vui chơi tại VinWonders.',
                'image_url' => 'phuquoc.jpg',
                'price' => 4800000,
                'departure_date' => '2026-06-20',
                'featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tour Biển Xanh Vũng Tàu - Nghỉ Dưỡng Resort 4 Sao',
                'description' => 'Chuyến đi cuối tuần thư giãn tại bãi Sau, check-in ngọn hải đăng và thưởng thức bánh khọt gốc vú sữa.',
                'image_url' => 'vungtau.jpg',
                'price' => 1890000,
                'departure_date' => '2026-05-30',
                'featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tour Khám Phá Cố Đô Huế - Đà Nẵng - Hội An',
                'description' => 'Hành trình di sản miền Trung, check-in Bà Nà Hills đường lên tiên cảnh và phố cổ đèn lồng lung linh.',
                'image_url' => 'mientrung.jpg',
                'price' => 5200000,
                'departure_date' => '2026-07-01',
                'featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}