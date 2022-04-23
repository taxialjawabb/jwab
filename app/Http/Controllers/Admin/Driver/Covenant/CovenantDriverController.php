<?php

namespace App\Http\Controllers\Admin\Driver\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use  App\Models\Covenant\CovenantItem;
use Carbon\Carbon;
use App\Models\Covenant\CovenantRecord;
use Illuminate\Support\Facades\Auth;

class CovenantDriverController extends Controller
{
    public function delivery_covenant($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $covenants = DB::select('select covenant_items.id, covenant_items.covenant_name, 
            covenant_items.serial_number, covenant_items.state , covenant_items.delivery_date
            from covenant_items where current_driver = ?', [$id]);
            $allCovenant =   \App\Models\Covenant\Covenant::all();
            return view('driver.covenant.showCovenant',compact('covenants', 'id', 'allCovenant'));
        }else{
            return back();
        }

    }

    public function show_add($id)
    {
        return view('driver.covenant.updateCovenant');
    }

    public function save_add(Request $request)
    {
        $request->validate([
            'id'=>'required|integer',
            'covenant_name'=>'required|string',
            'covenant_item'=>'required|string'
        ]);
        $covenantItem = CovenantItem::find($request->covenant_item);
        if($covenantItem !== null){
            $covenantItem->current_driver = $request->id ;
            $covenantItem-> state = 'active' ;
            $covenantItem-> delivery_date = Carbon::now();
            
            $covenantRecord  = new CovenantRecord;
            $covenantRecord->forign_type = 'driver';
            $covenantRecord->forign_id = $request->id;
            $covenantRecord->item_id = $request->covenant_item;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;
            
            $covenantItem->save();
            $covenantRecord->save();
            
            $request->session()->flash('status', 'تم تسليم العهد للسائق  نجاح');
        }
        else{
            $request->session()->flash('error', 'خطاء ');
        }
        return back(); 
    }
    public function show_item(Request $request)
    {
        $items =   CovenantItem::where('covenant_name', $request->id)->where('state', null)->get();

        return response()->json($items);

        
    }
}
