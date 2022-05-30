<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class TransferController extends Controller
{
    use GeneralTrait;
    public function check_transfer_rider(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric'
        ]);
        $rider = \App\Models\Rider::select(['id', 'account'])->find($request->rider_id);
        if($rider === null){
            return $this->returnError('E005',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $data = \App\Models\Driver::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    return $this -> returnData('data' , $data[0], 'driver data');   
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $data = \App\Models\Rider::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    return $this -> returnData('data' , $data[0], 'driver data');   
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else{
            return $this->returnError('E003',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }

    public function check_transfer_driver(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric'
        ]);
        $driver = \App\Models\Driver::select(['id', 'account'])->find($request->driver_id);
        if($driver === null){
            return $this->returnError('E005',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $data = \App\Models\Driver::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($driver->account > $request->money){
                    return $this -> returnData('data' , $data[0], 'driver data');   
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $data = \App\Models\Rider::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($driver->account > $request->money){
                    return $this -> returnData('data' , $data[0], 'driver data');   
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");
            }
        }
        else{
            return $this->returnError('E003',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }
}
