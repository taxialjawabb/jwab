<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\GeneralTrait;
use App\Models\Rider;
use App\Models\Driver;

class MessagesController extends Controller
{
    use GeneralTrait;

    public function send_message(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
        $rider = Rider::Where('phone', $request->phone)->get();
        if(count($rider) > 0){
            return $this->returnError('E001', 'phone number is already exist');
        }
        else{
            $message ="مرحبا عميل الجواب الرمز الخاص بك : ";
            $code = $this->send_code($request->phone, $message);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }
    public function send_message_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
            $message ="مرحبا عميل الجواب الرمز الخاص بك : ";
            $code = $this->send_code($request->phone, $message);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        
    }

    public function send_message_reset(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
        $rider = Rider::Where('phone', $request->phone)->get();
        if(count($rider) === 0){
            return $this->returnError('', 'phone number is exist');
        }
        else{
            $message ="مرحبا عميل الجواب لأعادة تغيير كلمة السرى الخاص بك: ";
            $code = $this->send_code($request->phone, $message);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function send_message_driver(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
        $driver = Driver::Where('phone', $request->phone)->get();
        if(count($driver) === 0){
            return $this->returnError('', 'phone number is not exist');
        }
        else{

            $message ="مرحبا سائق الجواب الرمز الخاص بك : ";
            $code = $this->send_code($request->phone, $message);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }
    public function send_message_driver_reset(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
        $driver = Driver::Where('phone', $request->phone)->get();

        if(count($driver) === 0){
            return $this->returnError('', 'phone number is not exist');
        }
        else{
            $message ="مرحبا سائق الجواب لأعادة تغيير كلمة المرور الخاص بك الرمز الخاص بك:";
            $code = false;
            if($driver[0]->state === 'active'){
                $code = $this->send_code($request->phone, $message);
            }
            if($code !== false){
                return $this->returnData('code' , $code ,$driver[0]->state);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function send_message_driver_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
            $message ="مرحبا سائق الجواب الرمز الخاص بك : ";
            $code = $this->send_code($request->phone, $message);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        
    }
}
