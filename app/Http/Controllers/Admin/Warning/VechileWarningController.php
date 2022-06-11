<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VechileWarningController extends Controller
{
    public function show($type)
    {
        
        if($type === 'driving_license_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, driving_license_expiration_date as ended_date, 
            DATEDIFF(driving_license_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 5  order by  days;");
            return view('warning.vechileWarning', compact('vechiles', 'type'));
        }
        else if($type === 'insurance_card_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, insurance_card_expiration_date as ended_date, 
            DATEDIFF(insurance_card_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 5  order by  days;");
            return view('warning.vechileWarning', compact('vechiles', 'type'));
        }
        else if($type === 'periodic_examination_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, periodic_examination_expiration_date as ended_date, 
            DATEDIFF(periodic_examination_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 5  order by  days;");
            return view('warning.vechileWarning', compact('vechiles', 'type'));
        }
        else if($type === 'operating_card_expiry_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, operating_card_expiry_date as ended_date, 
            DATEDIFF(operating_card_expiry_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 5  order by  days;");
            return view('warning.vechileWarning', compact('vechiles', 'type'));
        }
        else{
            return back();
        }
    }   

}