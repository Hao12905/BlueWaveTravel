<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCouponController extends Controller
{
    public function checkCoupon(Request $request)
    {
        return $this->check($request);
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = (float) $request->subtotal;
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'msg' => 'Vui lòng đăng nhập để dùng mã giảm giá!']);
        }

        $coupon = Coupon::where('code', $code)->where('status', 1)->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'msg' => 'Mã giảm giá không tồn tại!']);
        }

        if (($coupon->min_order ?? 0) > 0 && $subtotal < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'msg' => 'Đơn hàng cần tối thiểu ' . number_format($coupon->min_order, 0, ',', '.') . 'đ để dùng mã này!'
            ]);
        }

        $used = CouponHistory::where('user_id', $user->id)->where('coupon_code', $code)->exists();
        if ($used) {
            return response()->json(['success' => false, 'msg' => 'Bạn đã sử dụng mã giảm giá này rồi!']);
        }

        if (strtotime($coupon->expiry_date) < strtotime(date('Y-m-d'))) {
            return response()->json(['success' => false, 'msg' => 'Mã đã hết hạn!']);
        }

        if ($coupon->used_count >= $coupon->limit_usage) {
            return response()->json(['success' => false, 'msg' => 'Mã đã hết lượt sử dụng!']);
        }

        $discount = $this->calculateDiscount($coupon, $subtotal);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'total' => $subtotal - $discount,
            'msg' => 'Mã hợp lệ! Bạn được giảm ' . number_format($discount, 0, ',', '.') . 'đ.'
        ]);
    }

    private function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        $discount = $coupon->type === 'percent'
            ? ($subtotal * (float) $coupon->value / 100)
            : (float) $coupon->value;

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = (float) $coupon->max_discount;
        }

        return min($discount, $subtotal);
    }
}
