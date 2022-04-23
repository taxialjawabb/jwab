<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Vechile\BoxVechile;
use App\Models\Driver\BoxDriver;
use App\Models\Rider\BoxRider;
use App\Models\User\BoxUser;
use App\Models\Nathiraat\BoxNathriaat;
use App\Models\Driver;
use App\Models\Vechile;

class ConfirmBillsController extends Controller
{
    public function show_bills($type)
    {
        switch ($type) {
            case 'vechile':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_vechile where bond_state = 'waiting' group by bond_type;");
                $bills = DB::select("select box_vechile.id, driver.name, driver.phone, box_vechile.bond_type, box_vechile.payment_type, total_money , box_vechile.add_date
                from box_vechile ,driver where box_vechile.foreign_id = driver.id and box_vechile.foreign_type ='driver' and box_vechile.bond_state = 'waiting'
                UNION ALL
                select box_vechile.id, rider.name, rider.phone, box_vechile.bond_type, box_vechile.payment_type, total_money , box_vechile.add_date
                from box_vechile ,rider where box_vechile.foreign_id = rider.id and box_vechile.foreign_type ='rider' and box_vechile.bond_state = 'waiting'
                UNION ALL
                select box_vechile.id, box_vechile.vechile_id, '', box_vechile.bond_type, box_vechile.payment_type, total_money , box_vechile.add_date
                from box_vechile where box_vechile.foreign_type ='vechile' and  box_vechile.bond_state = 'waiting';");
                $take = 0;
                $spend = 0;
                if(count($totalBond)==2){
                    $take = $totalBond[1]->money;
                    $spend = $totalBond[0]->money;
                }
                else if(count($totalBond) == 1){
                    if($totalBond[0]->bond_type == 'take'){
                        $take = $totalBond[0]->money;
                    }
                    else if($totalBond[0]->bond_type == 'spend'){
                        $spend = $totalBond[0]->money;
                    }
                }
                return view('bills.billsWaitingConfirm', compact('bills', 'type', "take" , "spend"));
                break;            
            case 'driver':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_driver where bond_state = 'waiting' group by bond_type;");
                $bills = DB::select("select box_driver.id, driver.name, driver.phone, box_driver.bond_type, box_driver.payment_type, total_money , box_driver.add_date
                        from box_driver , driver where box_driver.driver_id = driver.id  and bond_state = 'waiting';");
                        $take = 0;
                        $spend = 0;
                        if(count($totalBond)==2){
                            $take = $totalBond[1]->money;
                            $spend = $totalBond[0]->money;
                        }
                        else if(count($totalBond) == 1){
                            if($totalBond[0]->bond_type == 'take'){
                                $take = $totalBond[0]->money;
                            }
                            else if($totalBond[0]->bond_type == 'spend'){
                                $spend = $totalBond[0]->money;
                            }
                        }
                return view('bills.billsWaitingConfirm', compact('bills', 'type',  "take" , "spend"));
                break;
            case 'rider':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_rider where bond_state = 'waiting' group by bond_type;");
                $bills = DB::select("select box_rider.id, rider.name, rider.phone, box_rider.bond_type, box_rider.payment_type, total_money , box_rider.add_date
                        from box_rider , rider where box_rider.rider_id = rider.id and bond_state = 'waiting';;");
                        $take = 0;
                        $spend = 0;
                        if(count($totalBond)==2){
                            $take = $totalBond[1]->money;
                            $spend = $totalBond[0]->money;
                        }
                        else if(count($totalBond) == 1){
                            if($totalBond[0]->bond_type == 'take'){
                                $take = $totalBond[0]->money;
                            }
                            else if($totalBond[0]->bond_type == 'spend'){
                                $spend = $totalBond[0]->money;
                            }
                        }
                return view('bills.billsWaitingConfirm', compact('bills', 'type', "take" , "spend"));
                break;
                case 'user':
                    $totalBond = DB::select(" select bond_type, sum(money) as money from box_user where bond_state = 'waiting' group by bond_type;");
                    $bills = DB::select("select box_user.id, admins.name, admins.phone, box_user.bond_type, box_user.payment_type, total_money , box_user.add_date
                            from box_user , admins where box_user.user_id = admins.id  and bond_state = 'waiting';");
                            $take = 0;
                            $spend = 0;
                            if(count($totalBond)==2){
                                $take = $totalBond[1]->money;
                                $spend = $totalBond[0]->money;
                            }
                            else if(count($totalBond) == 1){
                                if($totalBond[0]->bond_type == 'take'){
                                    $take = $totalBond[0]->money;
                                }
                                else if($totalBond[0]->bond_type == 'spend'){
                                    $spend = $totalBond[0]->money;
                                }
                            }
                    return view('bills.billsWaitingConfirm', compact('bills', 'type',  "take" , "spend"));
                    break;
            case 'nathiraat':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_nathriaat where bond_state = 'waiting' group by bond_type;");
                $bills = DB::select("select box_nathriaat.id,  bond_type, payment_type, total_money ,  box_nathriaat.descrpition,box_nathriaat.add_date, admins.name
                        from box_nathriaat , admins where box_nathriaat.add_by = admins.id and bond_state = 'waiting';;");
                        $take = 0;
                        $spend = 0;
                        if(count($totalBond)==2){
                            $take = $totalBond[1]->money;
                            $spend = $totalBond[0]->money;
                        }
                        else if(count($totalBond) == 1){
                            if($totalBond[0]->bond_type == 'take'){
                                $take = $totalBond[0]->money;
                            }
                            else if($totalBond[0]->bond_type == 'spend'){
                                $spend = $totalBond[0]->money;
                            }
                        }
                return view('bills.nathiraat.billsWaitingConfirm', compact('bills', 'type',  "take" , "spend"));
                break;
            default:
                return redirect('vechile/show');
                break;
        }
        
    }

    public function confirm_bills(Request $request)
    {
        if($request->id === null){
            return back();
        }
        switch ($request->type) {
            case 'vechile':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxVechile= BoxVechile::find($request->id[$i]);
                    $boxVechile->bond_state = 'confirmed';
                    $boxVechile->confirm_by =  Auth::guard('admin')->user()->id;
                    $boxVechile->confirm_date = Carbon::now();
                    $boxVechile->save();   
                }
                return back();
                break;
            
            case 'driver':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxDriver= BoxDriver::find($request->id[$i]);
                    $boxDriver->bond_state = 'confirmed';
                    $boxDriver->confirm_by =  Auth::guard('admin')->user()->id;
                    $boxDriver->confirm_date = Carbon::now();
                    $boxDriver->save();
                }
                return back();
                break;
            
            case 'rider':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxRider= BoxRider::find($request->id[$i]);
                    $boxRider->bond_state = 'confirmed';
                    $boxRider->confirm_by =  Auth::guard('admin')->user()->id;
                    $boxRider->confirm_date = Carbon::now();
                    $boxRider->save();
                }
                return back();
                break;
            
                case 'user':
                    for ($i=0; $i < count($request->id); $i++) { 
                        $boxUser= BoxUser::find($request->id[$i]);
                        $boxUser->bond_state = 'confirmed';
                        $boxUser->confirm_by =  Auth::guard('admin')->user()->id;
                        $boxUser->confirm_date = Carbon::now();
                        $boxUser->save();
                    }
                    return back();
                    break;
            
            case 'nathiraat':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxNathiraat= BoxNathriaat::find($request->id[$i]);
                    $boxNathiraat->bond_state = 'confirmed';
                    $boxNathiraat->confirm_by =  Auth::guard('admin')->user()->id;
                    $boxNathiraat->confirm_date = Carbon::now();
                    $boxNathiraat->save();
                }
                return back();
                break;
            
            default:
                return redirect('vechile/show');
                break;
        }

    }
}
