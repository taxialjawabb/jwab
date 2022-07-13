<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    
    public function requestsBooking(Request $request)
    {
        $state =$request->request_state;
        if($state=='expired')
        {

            $bookings = DB::select("
                select booking.id, ROUND(booking.price, 2) as price,  DATEDIFF(booking.end_date , booking.start_date) as days,
                rider.name as rider_name , rider.phone as rider_phone , driver.name as driver_name, driver.phone as driver_phone
                from booking  left join rider on booking.rider_id = rider.id
                left join driver on booking.driver_id = driver.id
                where booking.state= ? and booking.end_date < ?
            ", [$state,Carbon::now()]);
            return view('booking.bookings', compact('bookings', 'state'));

        }
        else
        {
        $bookings = DB::select("
                select booking.id, ROUND(booking.price, 2) as price,  DATEDIFF(booking.end_date , booking.start_date) as days,
                rider.name as rider_name , rider.phone as rider_phone , driver.name as driver_name, driver.phone as driver_phone
                from booking  left join rider on booking.rider_id = rider.id
                left join driver on booking.driver_id = driver.id
                where booking.state= ?
        ", [$state]);
        return view('booking.bookings', compact('bookings', 'state'));
}
    }
}
