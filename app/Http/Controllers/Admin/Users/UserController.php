<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Covenant\CovenantRecord;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function user_block($id)
    {
        $user = Admin::find($id);
        if($user != null){
            $userCovenants =  CovenantRecord::where('forign_type', 'user')
            ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get(); 
            if(count($userCovenants) > 0){
                if($userCovenants[0]->forign_id ===  $user->id){
                    $stored = DB::select("
                                        select covenant_name, count(covenant_items.id) as numbers
                                        from covenant_items, covenant_record
                                        where covenant_items.id= covenant_record.item_id 
                                        and forign_type ='user' and forign_id = ?
                                        and receive_by is null and receive_date is null 
                                        group by covenant_name;
                    ", [$id]);
                    
                    $covenants = DB::select("
                                            select covenant_items.id, covenant_items.serial_number, 
                                            covenant_items.state, admins.name as admin_name,
                                            covenant_items.add_date, driver.name as driver_name, driver.phone, covenant_items.delivery_date 
                                            from covenant_items  , driver , covenant_record , admins 
                                            where covenant_items.current_driver = driver.id 
                                            and  covenant_record.item_id = covenant_items.id 
                                            and covenant_record.delivery_by = admins.id and covenant_record.delivery_by = ?
                    ", [$id]);

                    return view('admin.users.covenantUser', compact('covenants', 'stored', 'user')); 
                }
            }
            if($user->state === "active"){
                $user->state = "blocked";
                session()->flash('status', 'تم أستبعاد المستخدم بنجاح');
            }
            else if($user->state === "blocked"){
                $user->state = "active";
                session()->flash('status', 'تم إلغاء الأستبعاد للمستخدم بنجاح');
            }
            $user->save();
        }
        return back();
    }

    public function confirm_block($id)
    {
        $user = Admin::find($id);
        if($user != null){
            if($user->state === "active"){
                $user->state = "blocked";
                session()->flash('status', 'تم أستبعاد المستخدم بنجاح');
            }
            else if($user->state === "blocked"){
                $user->state = "active";
                session()->flash('status', 'تم إلغاء الأستبعاد للمستخدم بنجاح');
            }
            $user->save();
            return redirect('user/detials/'.$user->id);
        }
        return back();
    }
}
