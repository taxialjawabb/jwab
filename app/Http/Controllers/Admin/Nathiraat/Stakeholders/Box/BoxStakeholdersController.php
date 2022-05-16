<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Nathiraat\BoxNathriaat;

class BoxStakeholdersController extends Controller
{
    public function show_box($type , $id)
    {
        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            if($type === 'spend'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, admins.name as admin_name
                from box_nathriaat as boxd , admins  where boxd.add_by=admins.id 
                and  stakeholders_id = ? and boxd.bond_type = 'spend';
                ", [$id]);
                return view('nathiraat.stakeholders.box.showBoxStakeholders', compact('stakeholder', 'bonds','type'));
            }
            else if($type === 'take'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, admins.name as admin_name
                from box_nathriaat as boxd , admins  where boxd.add_by=admins.id 
                and  stakeholders_id = ? and boxd.bond_type = 'take';
                ", [$id]);
                return view('nathiraat.stakeholders.box.showBoxStakeholders', compact('stakeholder', 'bonds','type'));
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
        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            return  view('nathiraat.stakeholders.box.addBoxStakeholders', compact('id'));
        }else{
            return back();
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'stakeholders_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        $stakeholder = Stakeholders::find($request->stakeholders_id);
        if($stakeholder !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxNathriaat = new BoxNathriaat;
            $boxNathriaat->stakeholders_id = $request->stakeholders_id;
            $boxNathriaat->bond_type = $request->bond_type;
            $boxNathriaat->payment_type = $request->payment_type;
            $boxNathriaat->money = $request->money;
            $boxNathriaat->tax = $request->tax;
            $boxNathriaat->total_money = $totalMoney;
            $boxNathriaat->descrpition = $request->descrpition;
            $boxNathriaat->add_date = Carbon::now();
            $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
            // if($request->bond_type === 'take'){
            //     $stakeholder-> account = $stakeholder-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $stakeholder-> account = $stakeholder-> account - $totalMoney;
            // }
            $boxNathriaat->save();
            // $stakeholder->save();
            
            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("nathiraat/stakeholders/box/show/".$request->bond_type ."/". $stakeholder->id);
        }else{
            return back();
        }

    }
}
