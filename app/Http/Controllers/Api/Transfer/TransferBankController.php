<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Rider\BankTransfer;
use App\Models\Rider;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;


class TransferBankController extends Controller
{
    use GeneralTrait;
    public function transfer_bank_rider(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'bank_name'    => 'required|string',
            'person_name'    => 'required|string',
            'money'   => 'required|string',
            'transfer_photo'=> 'required|mimes:jpeg,png,jpg,gif,svg',       
            
        ]);
        $rider = Rider::find($request->rider_id);
        if($rider == null){
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        else
        {
            $image="";
            if($request->hasFile('transfer_photo')){
     
                $file = $request->file('transfer_photo');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/riders/banktransfer'),$image);

            }
            $bankTransfer = BankTransfer::create([
                'rider_id' => $request->rider_id,
                'bank_name' => $request->bank_name,
                'person_name'=> $request->person_name ,
                'money'   => $request->money,
                'state' => 'pending',
                'transfer_photo'   => $image,
                
            ]);
            return $this -> returnData('data' , $bankTransfer, 'add transfer successfully watting for review');  
        }
       

      

       

    }
}
