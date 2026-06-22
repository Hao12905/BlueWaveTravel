<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    protected $table = 'coupon_history';
    public $timestamps = false;

    protected $fillable = ['user_id', 'coupon_code', 'used_at'];
    public function user() { return $this->belongsTo(User::class); }
}
