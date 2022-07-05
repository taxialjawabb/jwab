<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class BookingController extends Controller
{
    use GeneralTrait;
    public function booking_trip(Request $request)
    {
        
        $request->validate([
            'rider_id'   => 'required|string',
            'price'    => 'required|numeric',
            'start_loc_latitude'    => 'required|numeric',
            'start_loc_longtitude'    => 'required|numeric',
            'start_loc_name'   => 'required|string',
            'end_loc_latitude'    => 'required|numeric',
            'end_loc_longtitude'    => 'required|numeric',
            'end_loc_name'   => 'required|string',
            'distance'   => 'required|numeric',
            'trip_time'   => 'required|string',
            'going_time'   => 'required|string',
            'back_time'   => 'required|string',
            'has_return'   => 'required|boolean',
            'list_date'   => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',            
            'category_id' => 'required|string'
        ]);
        
        $rider = \App\Models\Rider::find($request->rider_id);
        if($rider == null){
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        else if($rider->account < $request->price){
            return $this->returnError('E002',"عفوا لا يوجد رصيد كافى");
        }

        $requestData=$request->only([
            'start_date',
            'end_date',
            'start_loc_latitude',
            'start_loc_longtitude',
            'start_loc_name',
            'end_loc_latitude',
            'end_loc_longtitude',
            'end_loc_name',
            'distance',
            'trip_time',
            'has_return',
            'going_time',
            'back_time',
            'list_date',
            'rider_id',
            'driver_id',
            'price',
            'category_id'
        ]);
        $requestData['state']="pending";

        $booking = \App\Models\Booking\Booking::create($requestData);
        return $this -> returnData('data' , $booking, 'successfully added watting for review');  
    }
    public function category()
    {
        $categories = \App\Models\Category::select([
            'id',
            'category_name',
            'basic_price',
            'km_cost',
            'minute_cost',
            'reject_cost',
            'cancel_cost',
            'percentage_type',
            'fixed_percentage',
            'category_percent'
            ])->where('show_in_app', true)->get();

            $bookingDiscount = \App\Models\Booking\BookingDiscount::all();
            $array = [
                        'category' => $categories, 
                        'discount' => $bookingDiscount
                    ];

            return $this -> returnData('booking' , $array, 'booking category and discount');
    }
}
