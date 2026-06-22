<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role', 
        'points', // Đã mở khóa để lưu điểm thưởng
        'status',
        'phone', 
        'full_name',
    ];

    public function bookings() 
    { 
        return $this->hasMany(Booking::class); 
    }

    public function couponHistories() 
    { 
        return $this->hasMany(CouponHistory::class); 
    }

    public $timestamps = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
