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
            DATEDIFF(Employment_contract_expiration_date , now()) as days from admins where DATEDIFF(Employment_contract_expiration_date , now()) < 5  order by  days;");
            return view('warning.userWarning', compact('data', 'type'));
        }
        else if($type === 'final_clearance_exity_date'){
            $data = DB::select("select id, name, phone, state, created_at, final_clearance_exity_date as ended_date, 
            DATEDIFF(final_clearance_exity_date , now()) as days from admins where DATEDIFF(final_clearance_exity_date , now()) < 5  order by  days;");
            return view('warning.userWarning', compact('data', 'type'));
        }
        else{
            return back();
        }
    }
}
