<?php

namespace App\Http\Controllers\Admin\Driver\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Driver;
use App\Models\Driver\BoxDriver;
use Illuminate\Support\Facades\Auth;
use App\Traits\InternalTransfer;

class BoxDriverController extends Controller
{
    use InternalTransfer;
    public function show_box($type , $id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            if($type === 'spend'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date, admins.name as admin_name
                from box_driver as boxd left join admins  on boxd.add_by=admins.id where  driver_id = ? and boxd.bond_type = 'spend'
                union
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date , '' as admin_name
                from box_vechile as boxd  where ( boxd.foreign_type='driver' and boxd.foreign_id = ? and boxd.bond_type = 'take') ;
                ", [$id, $id]);
                return view('driver.box.showBoxDriver', compact('driver', 'bonds','type'));
            }
            else if($type === 'take'){
                $bonds = DB::select("select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date,admins.name as admin_name
                from box_driver as boxd , driver ,admins  where  boxd.add_by = admins.id and boxd.driver_id = driver.id and driver.id = ? and boxd.bond_type = 'take' 
                union
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date , '' as admin_name
                from box_vechile as boxd  where ( boxd.foreign_type='driver' and boxd.foreign_id = ? and boxd.bond_type = 'spend') ;
                ;", [$id, $id]);
                return view('driver.box.showBoxDriver', compact('driver', 'bonds','type'));
            }
            else{
                return back();
            }
        }else{
            return back();
        }        

    }
    public function show_add($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            return  view('driver.box.addBoxDriver', compact('driver'));
        }else{
            return redirect('driver/show');
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'driver_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        if($request->has('stakeholder')){
            $request->validate([ 
                'stakeholder' =>'required|string|in:driver,vechile,rider,stakeholder,user',
                'user' => 'required|integer'
            ]); 
            $this->transfer($request);
        }
        $driver = Driver::find($request->driver_id);
        if($driver !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxDriver = new BoxDriver;
            $boxDriver->driver_id = $request->driver_id;
            $boxDriver->bond_type = $request->bond_type;
            $boxDriver->payment_type = $request->payment_type;
            $boxDriver->money = $request->money;
            $boxDriver->tax = $request->tax;
            $boxDriver->total_money = $totalMoney;
            $boxDriver->descrpition = $request->descrpition;
            $boxDriver->add_date = Carbon::now();
            $boxDriver->add_by = Auth::guard('admin')->user()->id;
            // if($request->bond_type === 'take'){
            //     $driver-> account = $driver-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $driver-> account = $driver-> account - $totalMoney;
            // }
            $boxDriver->save();
            // $driver->save();
            
            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("driver/box/show/".$request->bond_type ."/". $driver->id);
        }else{
            return redirect('driver/show');
        }

    }

    public function print_bond($id)
    {
        
    }
}
