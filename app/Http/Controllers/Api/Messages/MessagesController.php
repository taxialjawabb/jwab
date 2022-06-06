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
            // $code = rand(1000,9999);
            $code = 4455;
            $message ="مرحبا عميل الجواب الرمز الخاص بك : ".$code;
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnSuccessMessage($code);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
            }
        }
    }
    public function send_message_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);
            $code = 4455;
            // $code = rand(1000,9999);
            $message ="مرحبا عميل الجواب الرمز الخاص بك : ".$code;
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnSuccessMessage($code);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
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
            $code = 4455;
            // $code = rand(1000,9999);
            $message ="مرحبا عميل الجواب الرمز الخاص بك : ".$code .' لأعادة تغيير كلمة السرى الخاص بك. ';
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnSuccessMessage($code);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
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
            $code = 4455;
            // $code = rand(1000,9999);
            $message ="مرحبا سائق الجواب الرمز الخاص بك : ".$code;
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnSuccessMessage($code);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
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
            $code = 4455;
            // $code = rand(1000,9999);
            $message ="مرحبا سائق الجواب الرمز الخاص بك : ".$code .' لأعادة تغيير كلمة السرى الخاص بك. ';
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnData('code' , $code,$driver[0]->state);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
            }
        }
    }

    public function send_message_driver_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14' 
        ]);

            $code = 4455;
            // $code = rand(1000,9999);
            $message ="مرحبا سائق الجواب الرمز الخاص بك : ".$code;
            
            // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
            // $response = Http::get($ss);

            return $this->returnSuccessMessage($code);
            if($response->status() === 200){
            }
            else{
                return $this->returnError('', 'some thing is wrongs');
            }
        
    }
}
