<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;
use Carbon\Carbon;

class StakeholdersController extends Controller
{
    public function show_stakeholders()
    {
        $data =DB::select("select stakeholders.id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id ;");
        return view('nathiraat.stakeholders.showStakeholders',compact('data'));
    }
                        
    public function add_show(){
        return view('nathiraat.stakeholders.addStakeholders');
    }
    public function add_save(Request $request){
        $request->validate([            
            "name" => "required|string",
            "expire_date" => "required",
        ]);
        $stakeholders = new Stakeholders;
        $stakeholders->name  = $request->name ;
        $stakeholders->record_number  = $request->record_number ;
        $stakeholders->expire_date  = $request->expire_date ;
        $stakeholders->add_date = Carbon::now();
        $stakeholders->add_by = Auth::guard('admin')->user()->id;
        $stakeholders->save();
        $request->session()->flash('status', 'تم إضافة الجهة المستفيدة بنجاح');
        return back();
    }

    public function detials($id){
        $data = DB::select("select stakeholders.id as id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id and stakeholders.id = ? limit 1;", [$id]);
        if(count($data) > 0){
            $stakeholder = $data[0];
            return view('nathiraat.stakeholders.detials',compact('stakeholder'));
        }else{
            return back();
        }
    }

    public function update_show($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            $roles = \App\Models\Role::all();
            return view('admin.users.updateUser',compact('user','roles'));
        }else{
            return redirect('user/show');
        }
    }

    public function update_save(Request $request)
    {
        $request->validate([            
            "id" => "required|integer",
            "name" => "required|string",
            "phone" => "required|numeric",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $checkPhone = Admin::select('id')->where('phone', $request->phone)->where('id', '!=',$request->id)->get();
        $admin =  Admin::find($request->id);
        if(count($checkPhone) === 0){
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            if($request->has('phone') && strlen($request->phone) > 5){
                $admin->password  = Hash::make($request->password);
            }
            $admin->working_hours  = $request->working_hours ;
            $admin->monthly_salary  = $request->monthly_salary ;
            $admin->date_join  = $request->date_join ;
            $admin->Employment_contract_expiration_date  = $request->Employment_contract_expiration_date ;
            $admin->final_clearance_exity_date  = $request->final_clearance_exity_date ;
            $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();
            $admin->syncRoles([$request->role_id]);
            $request->session()->flash('status', 'تم إضافة المستخدم بنجاح');
        }else{
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');    
        }
        return back();
    }
}
