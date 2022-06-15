<?php

namespace App\Http\Controllers\Admin\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\Covenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Covenant\CovenantRecord;
use App\Models\Covenant\CovenantItem;

class CovenantManageController extends Controller
{
    public function show()
    {
        $covenants = DB::select('
            select covenant.id as id, covenant.covenant_name , count(covenant_items.id) as counts,
            admins.name as  add_by, covenant.add_date from covenant left join admins on covenant.add_by = admins.id
            left join covenant_items on covenant_items.covenant_name = covenant.covenant_name
            group by covenant.covenant_name order by covenant.id;
        ');
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

    public function receive_to_user(Request $request)
    {
        $request->validate([
            'user_id'=>'required|integer'
        ]);
        $covenantItems = CovenantItem::where("state" , null)->orWhere("state",'=' ,'waiting')->get();
        foreach ($covenantItems as $covenantItem) {
            $prevUserReceive =  CovenantRecord::where('item_id', $covenantItem->id)
                                                ->where('forign_type', 'user')
                                                ->where('receive_date', null)->get();
            if(count($prevUserReceive) >0){
                $prevUserReceive[0]->receive_date = Carbon::now();
                $prevUserReceive[0]->receive_by = Auth::guard('admin')->user()->id;
                $prevUserReceive[0]->save();
            }
            $covenantItem-> delivery_date = Carbon::now();
            $covenantItem-> current_driver = null;
            $covenantItem-> state = 'waiting' ;
            $covenantRecord  = new  CovenantRecord;
            $covenantRecord->forign_type = 'user';
            $covenantRecord->forign_id = $request->user_id;
            $covenantRecord->item_id = $covenantItem->id;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;

            $covenantItem->save();
            $covenantRecord->save();
        }
        return back();
    }
}
