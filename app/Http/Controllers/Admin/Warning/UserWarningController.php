<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserWarningController extends Controller
{
    public function show($type)
    {
        if($type === 'Employment_contract_expiration_date'){
            $data = DB::select("select id, name, phone, state, created_at, Employment_contract_expiration_date as ended_date, 
            DATEDIFF(Employment_contract_expiration_date , now()) as days from admins where state='active' and DATEDIFF(Employment_contract_expiration_date , now()) < 5  order by  days;");
            
            $contractClear   = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) > 60   ");
            $contractRemains = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) < 60 and  DATEDIFF(Employment_contract_expiration_date , now()) > 0   ");
            $contractExpired = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) < 0   ");
    
            $contractClear  = count($contractClear  ) > 0 ? $contractClear[0]->mycount: 0; 
            $contractRemains = count($contractRemains) > 0 ? $contractRemains[0]->mycount: 0;
            $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;

            return view('warning.userWarning', compact('data', 'type', 'contractClear' , 'contractRemains', 'contractExpired'));
        }
        else if($type === 'final_clearance_exity_date'){
            $data = DB::select("select id, name, phone, state, created_at, final_clearance_exity_date as ended_date, 
            DATEDIFF(final_clearance_exity_date , now()) as days from admins where state='active' and DATEDIFF(final_clearance_exity_date , now()) < 5  order by  days;");

            
            $clearanceClear   = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) > 60   ");
            $clearanceRemains = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) < 60 and  DATEDIFF(final_clearance_exity_date , now()) > 0   ");
            $clearanceExpired = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) < 0   ");
    
            $clearanceClear  = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0; 
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;
            return view('warning.userWarning', compact('data', 'type', 'clearanceClear' , 'clearanceRemains', 'clearanceExpired'));
        }
        else{
            return back();
        }
    }
}
