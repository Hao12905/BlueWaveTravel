<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'tour'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        DB::beginTransaction();

        try {
            $booking = Booking::findOrFail($id);
            $booking->status = $request->status;
            $booking->save();

            $pointsEarned = $this->awardPointsIfCompleted($booking);

            DB::commit();

            $message = 'Đơn hàng #' . $id . ' đã cập nhật thành công.';
            if ($pointsEarned > 0) {
                $message .= ' Khách hàng được cộng ' . number_format($pointsEarned, 0, ',', '.') . ' điểm.';
            }

            return redirect()->route('admin.bookings.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'Confirmed']);

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận!');
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'Cancelled']);

        return redirect()->back()->with('success', 'Đơn hàng đã bị hủy.');
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Đã xóa đơn hàng.');
    }

    private function awardPointsIfCompleted(Booking $booking): int
    {
        if ($booking->status !== 'Completed' || !empty($booking->points_awarded_at)) {
            return 0;
        }

        $user = User::find($booking->user_id);
        if (!$user) {
            return 0;
        }

        $pointsEarned = (int) floor(((float) $booking->total_amount) / 100000);
        if ($pointsEarned <= 0) {
            return 0;
        }

        $user->points = ($user->points ?? 0) + $pointsEarned;
        $user->save();

        if (Schema::hasColumn('bookings', 'points_earned')) {
            $booking->points_earned = $pointsEarned;
        }

        if (Schema::hasColumn('bookings', 'points_awarded_at')) {
            $booking->points_awarded_at = now();
        }

        $booking->save();

        return $pointsEarned;
    }
}
