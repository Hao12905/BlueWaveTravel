<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CompleteBookingController extends Controller
{
    public function show()
    {
        return view('complete-booking');
    }

    public function completeBooking()
    {
        return $this->show();
    }
}
