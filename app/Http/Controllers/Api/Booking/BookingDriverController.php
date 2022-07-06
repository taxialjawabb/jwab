<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use  App\Models\Booking\Booking;
use App\Models\Vechile\BoxVechile;
use App\Models\SecondaryCategory;

class BookingDriverController extends Controller
{
    use GeneralTrait;
    public function show_books(Request $request)
    {
        $request->validate([
            'vechile_id'   => 'required|string',
        ]);
        $vechile = \App\Models\Vechile::find($request->vechile_id);
        if($vechile !== null){
            $data =  Booking::where('category_id' , $vechile->category_id )->with('rider:id,name,phone')
            ->paginate(10);
            return $this->returnData('data' , $data, 'show available books for driver by vechile category');
        }
        else{
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }
   
    public function show_mybooks(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
        ]);
        $driver = \App\Models\Driver::find($request->driver_id);
        if($driver !== null){
            $data =  Booking::where('driver_id'  , $driver->id )->with('rider:id,name,phone')->paginate(10);
            return $this->returnData('data' , $data, "show driver's books by id");
        }
        else{
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }

    public function accept_book(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
            'booking_id'   => 'required|string',
        ]);
        $driver = \App\Models\Driver::find($request->driver_id);
        $vechile = \App\Models\Vechile::find($driver->current_vechile);
        $booking = Booking::find($request->booking_id);

        if($driver !== null && $booking !== null && $vechile !== null){

            $secondaryCategory = SecondaryCategory::find($vechile->secondary_id);
            if($secondaryCategory === null){
                return $this->returnError('E001',"الرجاء الرجوع للشركة لمراجعت بياناتك");
            }
            if($booking->state === 'pending'){

                $campany_cost = 0;
                $driver_cost = 0;
                if($secondaryCategory->percentage_type == 'fixed'){
                    $campany_cost =  $secondaryCategory->category_percent;
                    $driver_cost =  $booking->price - $campany_cost;
                }
                else if($secondaryCategory->percentage_type == 'percent'){

                    $campany_cost =  ($booking->price * ($secondaryCategory->category_percent /100));
                    $driver_cost = $booking->price -  $campany_cost;
                }
                // return $campany_cost ."=====". $driver_cost;
                $boxVechile1 = new BoxVechile();
                $boxVechile1->vechile_id = $vechile->id;
                $boxVechile1->foreign_type = 'driver';
                $boxVechile1->foreign_id = $driver->id;
                $boxVechile1->bond_type = 'take';
                $boxVechile1->payment_type = 'internal transfer';
                $boxVechile1->bond_state = 'deposited';
                $boxVechile1->descrpition =  'تم أضافة مبلغ '. $campany_cost .' للمركبة وذلك للإشتراك فى خدمة توصيل من الفترة '. $booking->start_date .' إلى الفترة' . $booking->end_date .'إشتراك رقم '. $booking->id;
                $boxVechile1->money = $campany_cost;
                $boxVechile1->tax = 0;
                $boxVechile1->total_money = $campany_cost;
                $boxVechile1->add_date = \Carbon\Carbon::now();
                
                $boxVechile2 = new BoxVechile();
                $boxVechile2->vechile_id = $vechile->id;
                $boxVechile2->foreign_type = 'driver';
                $boxVechile2->foreign_id = $driver->id;
                $boxVechile2->bond_type = 'spend';
                $boxVechile2->payment_type = 'internal transfer';
                $boxVechile2->bond_state = 'deposited';
                $boxVechile2->descrpition =  'تم أضافة مبلغ '. $driver_cost .' للسائق وذلك للإشتراك فى خدمة توصيل من الفترة '. $booking->start_date .' إلى الفترة' . $booking->end_date .'إشتراك رقم '. $booking->id;
                $boxVechile2->money = $driver_cost;
                $boxVechile2->tax = 0;
                $boxVechile2->total_money = $driver_cost;
                $boxVechile2->add_date = \Carbon\Carbon::now();
                $boxVechile1->save();
                $boxVechile2->save();
                $vechile->account += $campany_cost;
                $driver->account += $driver_cost;

                $vechile->save();
                $driver->save();
                $booking->state = 'active';
                $booking->save();
                $rider = \App\Models\Rider::find($booking->rider_id);
                $this->push_notification( $rider->remember_token , 'تم قبول الإشتراك  الخاص بك', 'الإشتراك يبداء من '. $request->start_date .' إلى الفترة' . $request->end_date .'إشتراك رقم '. $booking->id , 'discount');

                return $this->returnSuccessMessage("تم حفظ قبول هذا الاشتراك بنجاح ");
            }
            else{
                return $this->returnError('E001',"هذه الرحلة لم تعد متاحة");
            }
        }
        else{
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }


}
