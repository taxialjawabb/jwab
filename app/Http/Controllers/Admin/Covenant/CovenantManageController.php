<?php

namespace App\Http\Controllers\Admin\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\Covenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CovenantManageController extends Controller
{
    public function show()
    {
        $covenants = DB::select('select covenant.id as id, covenant.covenant_name , count(covenant_items.id) as counts,
        admins.name as  add_by, covenant.add_date from covenant left join admins on covenant.add_by = admins.id 
        left join covenant_items on covenant_items.covenant_name = covenant.covenant_name
         group by covenant.covenant_name order by covenant.id;');
        return view('covenant.showCovenant', compact('covenants'));
    }
    public function show_add()
    {

        return view('covenant.addCovenant');
    }
    public function save_add(Request $request)
    {
        $request->validate([
            'covenant_name'=>'required|string'
        ]);
        $data = Covenant::where('covenant_name',$request->covenant_name)->get();
        

        if(count($data) === 0){

            $covenant = new Covenant;
            $covenant->covenant_name = $request->covenant_name;
            $covenant->add_by = Auth::guard('admin')->user()->id;
            $covenant->add_date = Carbon::now();
            $covenant->save();

            return redirect('covenant/show');
            $request->session()->flash('status', 'تم أضافة العهد بنجاح');

        }
        else{
            $request->session()->flash('error', 'خطاء اسم العهدة موجود مسبقا');
            return redirect('covenant/show');
        }
    }
}
