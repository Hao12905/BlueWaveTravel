<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'title' => 'Vịnh Hạ Long - Du thuyền 5 sao',
                'description' => 'Khám phá kỳ quan thiên nhiên thế giới trên du thuyền cao cấp và thưởng thức hải sản địa phương.',
                'short_desc' => 'Hành trình nghỉ dưỡng trên vịnh di sản.',
                'price' => 3600000,
                'duration' => '2 ngày 1 đêm',
                'location' => 'Hạ Long',
                'category' => 'Miền Bắc',
                'image_url' => 'halong.jpg',
                'featured' => 1,
            ],
            [
                'title' => 'Phú Quốc - Thiên đường Đảo Ngọc',
                'description' => 'Khám phá biển xanh, cáp treo Hòn Thơm, hoàng hôn và các điểm vui chơi nổi bật tại Phú Quốc.',
                'short_desc' => 'Biển xanh và hoàng hôn trên Đảo Ngọc.',
                'price' => 5200000,
                'duration' => '4 ngày 3 đêm',
                'location' => 'Phú Quốc',
                'category' => 'Biển Đảo',
                'image_url' => 'phuquoc.jpg',
                'featured' => 1,
            ],
            [
                'title' => 'Đà Nẵng - Bà Nà Hills - Cầu Vàng',
                'description' => 'Tham quan thành phố biển Đà Nẵng, Bà Nà Hills, Cầu Vàng và trải nghiệm ẩm thực miền Trung.',
                'short_desc' => 'Kỳ nghỉ năng động tại thành phố đáng sống.',
                'price' => 3700000,
                'duration' => '3 ngày 2 đêm',
                'location' => 'Đà Nẵng',
                'category' => 'Miền Trung',
                'image_url' => 'danang.jpg',
                'featured' => 1,
            ],
            [
                'title' => 'Đảo Lý Sơn - Vương quốc tỏi',
                'description' => 'Khám phá cảnh quan núi lửa, biển trong xanh, cổng Tò Vò và văn hóa đặc trưng của đảo Lý Sơn.',
                'short_desc' => 'Hành trình khám phá đảo núi lửa độc đáo.',
                'price' => 3400000,
                'duration' => '3 ngày 2 đêm',
                'location' => 'Lý Sơn',
                'category' => 'Biển Đảo',
                'image_url' => 'lyson.jpg',
                'featured' => 1,
            ],
            [
                'title' => 'Đà Lạt - Thành phố ngàn hoa',
                'description' => 'Tận hưởng khí hậu mát mẻ, cảnh quan lãng mạn và những điểm check-in nổi tiếng của Đà Lạt.',
                'short_desc' => 'Không gian lãng mạn giữa cao nguyên.',
                'price' => 2300000,
                'duration' => '3 ngày 2 đêm',
                'location' => 'Đà Lạt',
                'category' => 'Miền Nam',
                'image_url' => 'dalat.jpg',
                'featured' => 0,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::updateOrCreate(['title' => $tour['title']], $tour);
        }
    }
}
