<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use Hash;
use Illuminate\Support\Facades\Http;


class DriverAuthController extends Controller
{   
    use GeneralTrait;
    public function login(Request $request)
    {
        try{
            $request->validate([
                'phone'    => ['required'],
                'password' => ['required'],
                'device_token' => ['required','string'],
            ]);

            $driver = Driver::where("phone",$request->phone)->get();
            if(count($driver) > 0){
                if($driver[0]->password == "0"){
                    $driver[0]->password = Hash::make($request->password);
                    $driver[0]->save();
                }
            }
            $credentials = $request->only(['phone', 'password']); 
            
            $token = Auth::guard('driver-api')->attempt($credentials);

            if(!$token){
                return $this->returnError('E001', 'some thing went wrongs');
            }else{
                $code = 4455;
                // $code = rand(1000,9999);
                // $message ="مرحبا سائق الجواب الرمز الخاص بك : ".$code;
                // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Asd@123123&numbers=".$request->phone."&sender=TaxiAljawab&message=".$message;
                // $response = Http::get($ss);

                $driverData = Auth::guard('driver-api') -> user();
                $driverData->remember_token = $request->device_token;
                $driverData->available = 0;
                $driverData->update();
                $driverData->api_token = $token;
                $driverData -> code = $code;
                return $this -> returnData('driver' , $driverData,'login successfuly');
                // if($response->status() === 200){
                // }
                // else{
                //     return $this->returnError('', 'some thing is wrongs sending verfication code');
                // }     
            }    
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
        
    }


    public function driver_data(Request $request)
    {
        $driverData = Auth::guard('driver-api') -> user();
        $driverData->api_token  = $request->header('auth-token');
        
        return $this -> returnData('driver' , $driverData,'driver data');
    }
    public function logout(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData -> remember_token = '';
                $driverData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            return $this->returnSuccessMessage("Logout Successfully");
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }

    public function email_update(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> email = $request->email;
                    $driverData->save();
                    $driverData->api_token = $token;
                    return $this -> returnData('driver' , $driverData,'Email updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Email is't not update");
            }
        }
        return $this->returnError('', "Email is't not update");
    }
    public function name_update(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> name = $request->name;
                    $driverData->save();
                    $driverData->api_token = $token;
                    return $this -> returnData('driver' , $driverData,'Name updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Name is't not update");
            }
        }
        return $this->returnError('', "Name is't not update");     
    }
    public function phone_update(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){ 
            try{
                $driverData = Auth::guard('driver-api') -> user();
                $driver = Driver::where('phone', $request->phone)->get();
                if(count($driver)){
                    return $this->returnError('', "Phone number already exist");
                }
                if($driverData !== null){
                    $driverData->phone = $request->phone;
                    $driverData->save();
                    $driverData->api_token = $token;
                    return $this -> returnData('driver' , $driverData,'Phone updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Phone is't not update");
            }
        }
        return $this->returnError('', "Phone is't not update");     
    }
    public function password_update(Request $request)
    {
        $request->validate([
            'new_password'    => ['required', 'string'],
            'old_password'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    if( Hash::check( $request->old_password, $driverData->password)){
                        
                        $driverData -> password =  Hash::make($request->new_password);
                        $driverData->save();
                        $driverData->api_token = $token;
                        return $this -> returnData('driver' , $driverData,'Password updated successfuly');
                    }
                    else{
                        return $this->returnError('', "Password is't not update");
                    }
                }else{
                    return $this->returnError('', "Password is't not update");
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Password is't not update");
            }
        }
        return $this->returnError('', "Password is't not update");     
    }

    public function send_message_driver_reset(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
            'new_password' => ['required', 'string'],
            'device_token' => ['required', 'string'],
        ]);
        $drivers = Driver::where('phone', $request->phone)->get();
        if(count($drivers) > 0 ){
            $driver = $drivers[0];
            $driver -> password =  Hash::make($request->new_password);
            $driver->remember_token = $request->device_token;
            $driver->available = 0;
            $driver->save();
            $token = Auth::guard('driver-api')->attempt(['phone' => $driver->phone, 'password' =>  $request->new_password]);
            if(!$token){
                return $this->returnError('E001', 'some thing went wrongs');
            }else{
                $driver->api_token = $token;
                return $this -> returnData('driver' , $driver,'reset password successfuly');    
            }  
        }
    }
}
