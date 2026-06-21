<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\CouponHistory;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    /**
     * Xu ly luu thong tin dat tour tu form modal ngoai frontend.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để đặt tour.');
        }

        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'fullname' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:departure_date',
            'payment_method' => 'nullable|string|max:255',
            'coupon_code' => 'nullable|string|max:50',
            'note' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $tour = Tour::findOrFail($request->tour_id);
        $subtotal = (float) $tour->price;
        $coupon = null;
        $discount = 0;
        $couponWarning = null;
        $authUser = Auth::user();
        $bookingEmail = $authUser?->email ?? $request->email;
        $bookingFullname = $authUser?->full_name ?? $request->fullname;

        DB::beginTransaction();
        try {
            if ($request->filled('coupon_code')) {
                try {
                    [$coupon, $discount] = $this->validateCoupon($request->coupon_code, $subtotal);
                } catch (ValidationException $e) {
                    $errors = $e->errors();
                    $couponWarning = $errors['coupon_code'][0] ?? 'Ma giam gia khong hop le.';
                    $coupon = null;
                    $discount = 0;
                }
            }

            $bookingUserId = $authUser?->id ?: User::where('email', $bookingEmail)->value('id');

            $booking = new Booking();
            $booking->user_id = $bookingUserId;
            $booking->tour_id = $tour->id;
            $booking->total_amount = $subtotal - $discount;
            $booking->status = 'Pending';

            $booking->fullname = $bookingFullname;
            $booking->phone = $request->phone;
            $booking->email = $bookingEmail;
            $booking->departure_date = $request->departure_date;
            if (Schema::hasColumn('bookings', 'end_date')) {
                $booking->end_date = $request->end_date;
            }
            $booking->payment_method = $request->input('payment_method') ?: 'Chưa chọn';
            $booking->note = $request->input('note', $request->input('notes'));

            if (Schema::hasColumn('bookings', 'original_amount')) {
                $booking->original_amount = $subtotal;
            }
            if (Schema::hasColumn('bookings', 'discount_amount')) {
                $booking->discount_amount = $discount;
            }
            if (Schema::hasColumn('bookings', 'coupon_code')) {
                $booking->coupon_code = $coupon?->code;
            }

            $booking->save();

            if ($coupon) {
                $coupon->increment('used_count');

                if (Auth::check()) {
                    CouponHistory::create([
                        'user_id' => Auth::id(),
                        'coupon_code' => $coupon->code,
                        'used_at' => now(),
                    ]);
                }
            }

            DB::commit();

            $message = 'Đặt tour thành công! Vui lòng đợi nhân viên gọi xác nhận.';
            if ($discount > 0) {
                $message .= ' Mã giảm giá ' . $coupon->code . ' đã được áp dụng, giảm ' . number_format($discount, 0, ',', '.') . 'đ.';
            }

            if ($couponWarning && $discount <= 0) {
                $message .= ' Ma giam gia khong ap dung duoc nen don da duoc tao voi gia goc.';
            }

            return redirect()->route('profile')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Không thể tạo đơn đặt tour: ' . $e->getMessage());
        }
    }

    private function validateCoupon(?string $code, float $subtotal): array
    {
        if (!Auth::check()) {
            throw ValidationException::withMessages(['coupon_code' => 'Vui lòng đăng nhập để dùng mã giảm giá.']);
        }

        $code = strtoupper(trim((string) $code));
        $coupon = Coupon::where('code', $code)->where('status', 1)->lockForUpdate()->first();

        if (!$coupon) {
            throw ValidationException::withMessages(['coupon_code' => 'Mã giảm giá không tồn tại.']);
        }

        if (($coupon->min_order ?? 0) > 0 && $subtotal < $coupon->min_order) {
            throw ValidationException::withMessages(['coupon_code' => 'Đơn hàng chưa đạt giá trị tối thiểu để dùng mã này.']);
        }

        if (CouponHistory::where('user_id', Auth::id())->where('coupon_code', $code)->exists()) {
            throw ValidationException::withMessages(['coupon_code' => 'Bạn đã sử dụng mã giảm giá này rồi.']);
        }

        if (strtotime($coupon->expiry_date) < strtotime(date('Y-m-d'))) {
            throw ValidationException::withMessages(['coupon_code' => 'Mã giảm giá đã hết hạn.']);
        }

        if ($coupon->used_count >= $coupon->limit_usage) {
            throw ValidationException::withMessages(['coupon_code' => 'Mã giảm giá đã hết lượt sử dụng.']);
        }

        $discount = $coupon->type === 'percent'
            ? ($subtotal * (float) $coupon->value / 100)
            : (float) $coupon->value;

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = (float) $coupon->max_discount;
        }

        return [$coupon, min($discount, $subtotal)];
    }
}
