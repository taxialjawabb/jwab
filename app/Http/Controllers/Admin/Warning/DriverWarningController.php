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
            return view('warning.driverWarning', compact('drivers', 'type'));
        }
        else if($type === 'license_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, license_expiration_date as ended_date, DATEDIFF(license_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 50  order by  days ;");
            return view('warning.driverWarning', compact('drivers', 'type'));
        }
        else if($type === 'contract_end_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, contract_end_date as ended_date, DATEDIFF(contract_end_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 50  order by  days ;");
            return view('warning.driverWarning', compact('drivers', 'type'));
        }
        else if($type === 'final_clearance_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, final_clearance_date as ended_date, DATEDIFF(final_clearance_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 50  order by  days ;");
            return view('warning.driverWarning', compact('drivers', 'type'));
        }
        else{
            return back();
        }
    }
}
