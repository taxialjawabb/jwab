<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverWarningController extends Controller
{
    public function show($type)
    {
        if($type === 'id_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, id_expiration_date as ended_date, DATEDIFF(id_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 50  order by  days ;");
            
            $idClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) > 60   ");
            $idRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60 and  DATEDIFF(id_expiration_date , now()) > 0   ");
            $idExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 0   ");

            $idClear  = count($idClear  ) > 0 ? $idClear[0]->mycount: 0; 
            $idRemains = count($idRemains) > 0 ? $idRemains[0]->mycount: 0;
            $idExpired = count($idExpired) > 0 ? $idExpired[0]->mycount: 0;

            return view('warning.driverWarning', compact(
                'drivers', 
                'type',
                'idClear' ,
                'idRemains',
                'idExpired',
            
            ));
        }
        else if($type === 'license_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, license_expiration_date as ended_date, DATEDIFF(license_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 50  order by  days ;");

            $licenseClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) > 60   ");
            $licenseRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60 and  DATEDIFF(license_expiration_date , now()) > 0   ");
            $licenseExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 0   ");
    
            $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0; 
            $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
            $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;
            return view('warning.driverWarning', compact('drivers', 'type', 'licenseClear' , 'licenseRemains', 'licenseExpired'));
        }
        else if($type === 'contract_end_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, contract_end_date as ended_date, DATEDIFF(contract_end_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 50  order by  days ;");

            $contractClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) > 60   ");
            $contractRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 60 and  DATEDIFF(contract_end_date , now()) > 0   ");
            $contractExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 0   ");
    
            $contractClear  = count($contractClear  ) > 0 ? $contractClear[0]->mycount: 0; 
            $contractRemains = count($contractRemains) > 0 ? $contractRemains[0]->mycount: 0;
            $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;
            return view('warning.driverWarning', compact('drivers', 'type', 'contractClear' , 'contractRemains', 'contractExpired'));
        }
        else if($type === 'final_clearance_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, final_clearance_date as ended_date, DATEDIFF(final_clearance_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 50  order by  days ;");

            $clearanceClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) > 60   ");
            $clearanceRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 60 and  DATEDIFF(final_clearance_date , now()) > 0   ");
            $clearanceExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 0   ");
    
            $clearanceClear  = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0; 
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;
            return view('warning.driverWarning', compact('drivers', 'type', 'clearanceClear' , 'clearanceRemains', 'clearanceExpired'));
        }
        else{
            return back();
        }
    }
}
