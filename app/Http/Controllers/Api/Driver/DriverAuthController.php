<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Version;
use Hash;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Driver\DriverDocuments;


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
                $driverData = Auth::guard('driver-api') -> user();
                $driverData->remember_token = $request->device_token;
                $driverData->available = 0;
                $driverData->update();
                $driverData->api_token = $token;
                $verison = Version::all();
                $driverData -> version = $verison[0]->driver;
                $driverData -> updating = $verison[0]->driver_state;
                $driverData -> iosVersion = $verison[1]->driver;
                $driverData -> iosUpdating = $verison[1]->driver_state;
                return $this -> returnData('driver' , $driverData,'login successfuly');  
            }    
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
        
    }

    public function chech_phone(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string', 'min:10', 'max:10'],
            'phone_id'    => ['required', 'string'],
        ]);
        $driver = Driver::where("phone",$request->phone)->get();
        if(count($driver) > 0 && $driver[0]->state === 'deleted'){
            return $this->returnError('E001', "phone number is deleted ");
            
        }
        if(count($driver) > 0 && $driver[0]->state === 'blocked'){
            return $this->returnError('E002', "phone number is blocked ");            
        }
        if(count($driver) > 0){
            return $this -> returnSuccessMessage('true');
                        
        }
        else{
            $message ="?????????? ???????? ???????????? ?????????? ";
            // return $this->send_code($request->phone, $message);
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                return $this -> returnData('code' , $code,'false');
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function driver_data(Request $request)
    {
        $driverData = Auth::guard('driver-api') -> user();
        if($driverData !== null){
            $driverData->available = 1;
            $driverData->save();
            $driverData->api_token  = $request->header('auth-token');
            $verison = Version::all();
            $driverData -> version = $verison[0]->driver;
            $driverData -> updating = $verison[0]->driver_state;            
            $driverData -> iosVersion = $verison[1]->driver;
            $driverData -> iosUpdating = $verison[1]->driver_state;
            return $this -> returnData('driver' , $driverData,'driver data');
        }
        else{
            return $this->returnError('E001', "driver not exist ");

        }
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
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;    
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
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;    
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
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;                    
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;
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
                        $verison = Version::all();
                        $driverData -> version = $verison[0]->driver;
                        $driverData -> updating = $verison[0]->driver_state;
                        $driverData -> iosVersion = $verison[1]->driver;
                        $driverData -> iosUpdating = $verison[1]->driver_state;        
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

    public function id_expiration_date_update(Request $request)
    {
        $request->validate([
            'id_expiration_date'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> id_expiration_date = $request->id_expiration_date;
                    $driverData->save();
                    $driverData->api_token = $token;
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;    
                    return $this -> returnData('driver' , $driverData,'id expiration date has ben updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Name is't not update");
            }
        }
        return $this->returnError('', "Name is't not update");     
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
                $verison = Version::all();
                $driver-> version = $verison[0]->driver;
                $driver-> updating = $verison[0]->driver_state;
                $driver-> iosVersion = $verison[1]->driver;
                $driver-> iosUpdating = $verison[1]->driver_state;
                return $this -> returnData('driver' , $driver,'reset password successfuly');    
            }  
        }else{
            return $this->returnError('E002', 'error in driver data');
        }
    }
    
    public function add_driver(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'nationality' => 'required|string',
            'ssd' => 'required|string',
            'address' => 'required|string',
            'id_copy_no' => 'required|string',
            'id_expiration_date' => 'required|string',
            'license_type' => 'required|string',
            'license_expiration_date' => 'required|string',
            'birth_date' => 'required|string',
            // 'start_working_date' => 'required|string',
            // 'contract_end_date' => 'required|string',
            // 'final_clearance_date' => 'required|string',
            'phone' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,',
            'id_image' => 'required|mimes:jpeg,png,jpg,',
            'license_image' => 'required|mimes:jpeg,png,jpg,',
        ]);

        $driverData = Driver::where('ssd', $request->ssd)->orWhere('phone', $request->phone)->get();
        if(count($driverData) > 0 ){
            return $this->returnError('E001', '?????? ???????????????? ???????????? ????????????');
        }
        else{
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->password = '0' ;
            $driver->nationality = $request->nationality;
            $driver->ssd = $request->ssd;
            $driver->state = 'pending';
            $driver->address = $request->address;
            $driver->id_copy_no = $request->id_copy_no;
            $driver->id_expiration_date = $request->id_expiration_date;
            $driver->license_type = $request->license_type;
            $driver->license_expiration_date = $request->license_expiration_date;
            $driver->birth_date = $request->birth_date;
            // $driver->start_working_date = $request->start_working_date;
            // $driver->contract_end_date = $request->contract_end_date;
            // $driver->final_clearance_date = $request->final_clearance_date;
            $driver->phone = $request->phone;
            // $driver->admin_id = Auth::guard('admin')->user()->id;
            $driver->group_id = 1;
            $driver->add_date = Carbon::now();
        
        if($request->hasFile('image')){
            $file = $request->file('image');
			$name = $file->getClientOriginalName();
			$ext  = $file->getClientOriginalExtension();
			$size = $file->getSize();
			$mim  = $file->getMimeType();
			$realpath = $file->getRealPath();
			$image = time().'.'.$ext;
			$file->move(public_path('images/drivers/personal_phonto'),$image);
			$driver->persnol_photo =  $image;
	
		}
        $driver->save();

        $this->add_document($driver->id, '???????? ???????????? ????????????' , '???????? ???????????? ???????????? ?????? ?????????????? ???? ???????? ??????????????', $request->file('id_image'));
        $this->add_document($driver->id, '???????? ???????? ?????????????? ????????????' , '???????? ???????? ?????????????? ???????????? ?????? ?????????????? ???? ???????? ??????????????', $request->file('license_image'));
        return $this->returnSuccessMessage("???? ?????????? ?????????????? ?????????? ");
    }
    return $this->returnError('E001', '?????? ???????? ????');

    }

    public function block_account(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData -> state = 'deleted';
                $driverData -> remember_token = '';
                $driverData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            return $this->returnSuccessMessage("delete account succesfully");
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }

    public function add_document($driver_id, $title , $content, $file)
    {
        $name = $file->getClientOriginalName();
        $ext  = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $mim  = $file->getMimeType();
        $realpath = $file->getRealPath();
        $image = time().'.'.$ext;
        $file->move(public_path('images/drivers/documents'),$image);
        $document = new DriverDocuments;
        $document->document_type = $title;
        $document->content = $content;
        $document->add_date = Carbon::now();
        // $document->admin_id = Auth::guard('admin')->user()->id;
        $document->driver_id = $driver_id;
        $document->attached = $image;
        $document->save();
    }
}
