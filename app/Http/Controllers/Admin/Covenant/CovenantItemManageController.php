<?php

namespace App\Http\Controllers\Admin\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\Covenant;
use  App\Models\Covenant\CovenantItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CovenantItemManageController extends Controller
{
    public function show_add($id)
    {
        $covenants = Covenant::select(['covenant_name'])->where('id', $id)->get();
        return view('covenant.addItemCovenant', compact('covenants'));

    }
    public function show($covenant)
    {
        $covenants = DB::select("select covenant_items.id, covenant_items.serial_number, covenant_items.state, admins.name as admin_name,
        covenant_items.add_date, driver.name as driver_name, covenant_items.delivery_date 
        from covenant_items left join admins on covenant_items.add_by = admins.id left join driver on covenant_items.current_driver = driver.id where  covenant_items.covenant_name =? ;	", [$covenant]);
        return view('covenant.showItemCovenant', compact('covenants'));
    }
    public function save_add(Request $request)
    {
        // return $request->all();
        $request->validate([
            'covenant_name'=>'required|string'
        ]);
            $dataItems = $request->serial;
            if(count($dataItems) > 0){
                for ($i=0; $i < count($dataItems); $i++) { 
                    $covenantItem = new CovenantItem;
                    $covenantItem->covenant_name = $request->covenant_name;
                    $covenantItem->add_by = Auth::guard('admin')->user()->id;
                    $covenantItem->add_date = Carbon::now();
                    $covenantItem->serial_number = $dataItems[$i];
                    $covenantItem->save();
                }
            $request->session()->flash('status', 'تم أضافة العهد بنجاح');
            return redirect('covenant/show');
        }
        else{
            $request->session()->flash('error', 'خطاء ');
            return back(); 
        }
    }
    
}
