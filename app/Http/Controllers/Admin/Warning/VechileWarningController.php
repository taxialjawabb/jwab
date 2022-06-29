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

            $licenseClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) > 60   ");
            $licenseRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 60 and  DATEDIFF(driving_license_expiration_date , now()) > 0   ");
            $licenseExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 0   ");
    
            $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0; 
            $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
            $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;

            return view('warning.vechileWarning', compact('vechiles', 'type', 'licenseClear' , 'licenseRemains', 'licenseExpired'));
        }
        else if($type === 'insurance_card_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, insurance_card_expiration_date as ended_date, 
            DATEDIFF(insurance_card_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 5  order by  days;");

            $insuranceClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) > 60   ");
            $insuranceRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 60 and  DATEDIFF(insurance_card_expiration_date , now()) > 0   ");
            $insuranceExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 0   ");
    
            $insuranceClear  = count($insuranceClear  ) > 0 ? $insuranceClear[0]->mycount: 0; 
            $insuranceRemains = count($insuranceRemains) > 0 ? $insuranceRemains[0]->mycount: 0;
            $insuranceExpired = count($insuranceExpired) > 0 ? $insuranceExpired[0]->mycount: 0;
            return view('warning.vechileWarning', compact('vechiles', 'type', 'insuranceClear' , 'insuranceRemains', 'insuranceExpired'));
        }
        else if($type === 'periodic_examination_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, periodic_examination_expiration_date as ended_date, 
            DATEDIFF(periodic_examination_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 5  order by  days;");

            $examinationClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) > 60   ");
            $examinationRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 60 and  DATEDIFF(periodic_examination_expiration_date , now()) > 0   ");
            $examinationExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 0   ");
    
            $examinationClear  = count($examinationClear  ) > 0 ? $examinationClear[0]->mycount: 0; 
            $examinationRemains = count($examinationRemains) > 0 ? $examinationRemains[0]->mycount: 0;
            $examinationExpired = count($examinationExpired) > 0 ? $examinationExpired[0]->mycount: 0;
            return view('warning.vechileWarning', compact('vechiles', 'type', 'examinationClear' , 'examinationRemains', 'examinationExpired'));
        }
        else if($type === 'operating_card_expiry_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, add_date, operating_card_expiry_date as ended_date, 
            DATEDIFF(operating_card_expiry_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 5  order by  days;");

            $operatingClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) > 60   ");
            $operatingRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 60 and  DATEDIFF(operating_card_expiry_date , now()) > 0   ");
            $operatingExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 0   ");
    
            $operatingClear  = count($operatingClear  ) > 0 ? $operatingClear[0]->mycount: 0; 
            $operatingRemains = count($operatingRemains) > 0 ? $operatingRemains[0]->mycount: 0;
            $operatingExpired = count($operatingExpired) > 0 ? $operatingExpired[0]->mycount: 0;
            return view('warning.vechileWarning', compact('vechiles', 'type', 'operatingClear' , 'operatingRemains', 'operatingExpired'));
        }
        else{
            return back();
        }
    }   

}