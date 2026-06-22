<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    // 1. Định danh chính xác tên bảng trong database của bạn
    protected $table = 'tours';

    // 2. Tắt cơ chế tự động quản lý cặp timestamps (vì bảng tours không có cột updated_at)
    public $timestamps = false;

    // 3. Mở khóa ghi dữ liệu hàng loạt cho các trường từ Form Admin gửi lên
    protected $fillable = [
        'title',
        'description',
        'short_desc',
        'price',
        'duration',
        'location',
        'category',
        'image_url',
        'featured'
    ];

    // 4. Ép kiểu dữ liệu (Cập nhật mới giúp nhận diện trạng thái Nổi bật chuẩn xác)
    protected $casts = [
        'featured' => 'boolean'
    ];
    public function bookings() 
    { 
        return $this->hasMany(Booking::class); 
    }
}