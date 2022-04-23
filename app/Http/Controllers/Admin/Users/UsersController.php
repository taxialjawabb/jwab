<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show_users()
    {
        $users =DB::select("select users.id, users.name , users.phone, users.created_at, ad.name as add_by
                            from admins as users left join admins as ad on users.add_by = ad.id;");
        // $users = Admin::leftJoin('admins', 'admins.id', '=', ' admins.id')
        // ->get();
        $data = [];
        for ($i=0; $i < count($users) ; $i++) { 
                $admin = new Admin;
                $admin->id = $users[$i]->id;
                $admin->name = $users[$i]->name;
                $admin->phone = $users[$i]->phone;
                $admin->created_at = $users[$i]->created_at;
                $admin->add_by = $users[$i]->add_by;
                $data[$i] = $admin;
        }

        //return dd($data);
        return view('admin.users.showUser',compact('data'));
    }
                        
    public function add_show(Request $request){
        $roles = \App\Models\Role::all();
        return view('admin.users.addUser', compact('roles'));
    }
    public function add_save(Request $request){
        $request->validate([            
            "name" => "required|string",
            "phone" => "required|numeric",
            "department" => "required|string",
            "nationality" => "required|string",
            "ssd" => "required",
            "password" => "required",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $checkPhone = Admin::select('id')->where('phone', $request->phone)->orWhere('ssd', $request->ssd)->get();
        if(count($checkPhone) === 0){
            $admin = new Admin;
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            $admin->department  = $request->department ;
            $admin->nationality  = $request->nationality ;
            $admin->ssd  = $request->ssd ;
            $admin->password  = Hash::make($request->password);
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

    public function detials($id){
        $user = Admin::find($id);
        if($user !== null){
            return view('admin.users.detials',compact('user'));
        }else{
            return redirect('user/show');
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
            "department" => "required|string",
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
            $admin->department  = $request->department ;
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
