<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;

    protected $fillable = ['code', 'type', 'value', 'max_discount', 'min_order', 'limit_usage', 'used_count', 'expiry_date', 'status'];
}
