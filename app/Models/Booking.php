<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Tắt timestamps vì bảng của bạn không có created_at/updated_at
    public $timestamps = false;
    
    // Tên bảng
    protected $table = 'bookings';

    // Các trường cho phép ghi dữ liệu
    protected $fillable = [
        'user_id',
        'tour_id',
        'booking_date',
        'departure_date',
        'end_date',
        'quantity',
        'fullname',
        'phone',
        'email',
        'payment_method',
        'original_amount',
        'discount_amount',
        'coupon_code',
        'total_amount',
        'points_earned',
        'points_awarded_at',
        'total_price',
        'status'
    ];

    // Quan hệ với User
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    // Quan hệ với Tour
    public function tour() 
    { 
        return $this->belongsTo(Tour::class); 
    }
}
