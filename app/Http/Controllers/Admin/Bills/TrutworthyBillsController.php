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

class TrutworthyBillsController extends Controller
{
    public function show_bills($type)
    {
        switch ($type) {
            case 'vechile':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_vechile where bond_state = 'confirmed' group by bond_type;");
                $bills = DB::select("select box_vechile.id, driver.name, driver.phone, box_vechile.bond_type, box_vechile.payment_type, total_money , admins.name as confirmed_by, box_vechile.confirm_date
                            from box_vechile ,driver, admins where (box_vechile.confirm_by = admins.id and box_vechile.bond_state = 'confirmed' ) and box_vechile.foreign_id = driver.id and box_vechile.foreign_type ='driver' 
                            UNION ALL
                            select box_vechile.id, rider.name, rider.phone, box_vechile.bond_type, box_vechile.payment_type, total_money , admins.name as confirmed_by, box_vechile.confirm_date
                            from box_vechile ,rider, admins where (box_vechile.confirm_by = admins.id and box_vechile.bond_state = 'confirmed') and  box_vechile.foreign_id = rider.id and box_vechile.foreign_type ='rider' 
                            UNION ALL
                            select box_vechile.id, box_vechile.vechile_id, '', box_vechile.bond_type, box_vechile.payment_type, total_money , admins.name as confirmed_by, box_vechile.confirm_date
                            from box_vechile, admins where (box_vechile.confirm_by = admins.id and  box_vechile.bond_state = 'confirmed') and  box_vechile.foreign_type ='vechile' ;");
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
                return view('bills.billsWaitingTrustworthy', compact('bills', 'type', "take" , "spend"));
                break;            
            case 'driver':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_driver where bond_state = 'confirmed' group by bond_type;");
                $bills = DB::select("select box_driver.id, driver.name, driver.phone, box_driver.bond_type, box_driver.payment_type, total_money , admins.name as confirmed_by, box_driver.confirm_date
                            from box_driver , driver, admins  where (box_driver.confirm_by = admins.id and bond_state = 'confirmed') and box_driver.driver_id = driver.id ;");
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
                return view('bills.billsWaitingTrustworthy', compact('bills', 'type', "take" , "spend"));
                break;
            case 'rider':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_rider where bond_state = 'confirmed' group by bond_type;");
                $bills = DB::select("select box_rider.id, rider.name, rider.phone, box_rider.bond_type, box_rider.payment_type, total_money , admins.name as confirmed_by, box_rider.confirm_date
                            from box_rider , rider, admins  where (box_rider.confirm_by = admins.id and bond_state = 'confirmed') and box_rider.rider_id = rider.id ;");
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
                return view('bills.billsWaitingTrustworthy', compact('bills', 'type', "take" , "spend"));
                break;
            
                case 'user':
                    $totalBond = DB::select(" select bond_type, sum(money) as money from box_user where bond_state = 'confirmed' group by bond_type;");
                    $bills = DB::select("select box_user.id, user.name, user.phone, box_user.bond_type, box_user.payment_type, total_money , ad.name as confirmed_by, box_user.confirm_date
                                from box_user , admins as user, admins as ad  where (box_user.confirm_by = ad.id and bond_state = 'confirmed') and box_user.user_id = user.id ;");
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
                    return view('bills.billsWaitingTrustworthy', compact('bills', 'type', "take" , "spend"));
                    break;

            case 'nathiraat':
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_nathriaat where bond_state = 'confirmed' group by bond_type;");
                $bills = DB::select("select box_nathriaat.id,  bond_type, payment_type, total_money ,  box_nathriaat.descrpition, admins.name as confirmed_by, confirm_date
                        from box_nathriaat , admins where box_nathriaat.add_by = admins.id and bond_state = 'confirmed';");
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
                return view('bills.nathiraat.billsWaitingTrustworthy', compact('bills', 'type', "take" , "spend"));
                break;
            default:
                return redirect('vechile/show');
                break;
        }
        
    }

    public function trustworthy_bills(Request $request)
    {
        if($request->id === null){
            return back();
        }
        switch ($request->type) {
            case 'vechile':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxVechile= BoxVechile::find($request->id[$i]);
                    $boxVechile->bond_state = 'trustworthy';
                    $boxVechile->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxVechile->trustworthy_date = Carbon::now();
                    if($boxVechile->payment_type == 'bank transfer'  || $boxVechile->payment_type == 'selling points' || $boxVechile->payment_type == 'electronic payment'){
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxVechile->deposit_date = Carbon::now();
                        if($boxVechile->bond_type == "spend"){
                            $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                        }
                        else if($boxVechile->bond_type == "take"){
                            $this->generalBox( $boxVechile->total_money,0 , Carbon::now());
                        }
                    }
                    if($boxVechile->payment_type == 'cash' && $boxVechile->bond_type == "spend"){
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxVechile->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                    }
                    $boxVechile->save();
                }
                return back();
                break;
            
            case 'driver':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxDriver= BoxDriver::find($request->id[$i]);
                    $boxDriver->bond_state = 'trustworthy';
                    $boxDriver->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxDriver->trustworthy_date = Carbon::now();
                    if($boxDriver->payment_type == 'bank transfer'  || $boxDriver->payment_type == 'selling points' || $boxDriver->payment_type == 'electronic payment'){
                        $boxDriver->bond_state = 'deposited';
                        $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxDriver->deposit_date = Carbon::now();
                        if($boxDriver->bond_type == "spend"){
                            $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                        }
                        else if($boxDriver->bond_type == "take"){
                            $this->generalBox( $boxDriver->total_money,0 , Carbon::now());
                        }
                    }
                    if($boxDriver->payment_type == 'cash' && $boxDriver->bond_type == "spend"){
                        $boxDriver->bond_state = 'deposited';
                        $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxDriver->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                    }
                    $boxDriver->save();
                }
                return back();
                break;
            
            case 'rider':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxRider= BoxRider::find($request->id[$i]);
                    $boxRider->bond_state = 'trustworthy';
                    $boxRider->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxRider->trustworthy_date = Carbon::now();
                    if($boxRider->payment_type == 'bank transfer'  || $boxRider->payment_type == 'selling points' || $boxRider->payment_type == 'electronic payment'){
                        $boxRider->bond_state = 'deposited';
                        $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxRider->deposit_date = Carbon::now();
                        if($boxRider->bond_type == "spend"){
                            $this->generalBox(0, $boxRider->total_money , Carbon::now());
                        }
                        else if($boxRider->bond_type == "take"){
                            $this->generalBox( $boxRider->total_money,0 , Carbon::now());
                        }
                    }
                    if($boxRider->payment_type == 'cash' && $boxRider->bond_type == "spend"){
                        $boxRider->bond_state = 'deposited';
                        $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxRider->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxRider->total_money , Carbon::now());
                    }
                    $boxRider->save();
                }
                return back();
                break;
            
                case 'user':
                    for ($i=0; $i < count($request->id); $i++) { 
                        $boxUser= BoxUser::find($request->id[$i]);
                        $boxUser->bond_state = 'trustworthy';
                        $boxUser->trustworthy_by =  Auth::guard('admin')->user()->id;
                        $boxUser->trustworthy_date = Carbon::now();
                        if($boxUser->payment_type == 'bank transfer'  || $boxUser->payment_type == 'selling points' || $boxUser->payment_type == 'electronic payment'){
                            $boxUser->bond_state = 'deposited';
                            $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                            $boxUser->deposit_date = Carbon::now();
                            if($boxUser->bond_type == "spend"){
                                $this->generalBox(0, $boxUser->total_money , Carbon::now());
                            }
                            else if($boxUser->bond_type == "take"){
                                $this->generalBox( $boxUser->total_money,0 , Carbon::now());
                            }
                        }
                        if($boxUser->payment_type == 'cash' && $boxUser->bond_type == "spend"){
                            $boxUser->bond_state = 'deposited';
                            $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                            $boxUser->deposit_date = Carbon::now();
                            $this->generalBox(0, $boxUser->total_money , Carbon::now());
                        }
                        $boxUser->save();
                    }
                    return back();
                    break;

            case 'nathiraat':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxNathiraat= BoxNathriaat::find($request->id[$i]);
                    $boxNathiraat->bond_state = 'trustworthy';
                    $boxNathiraat->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxNathiraat->trustworthy_date = Carbon::now();
                    if($boxNathiraat->payment_type == 'bank transfer'  || $boxNathiraat->payment_type == 'selling points' || $boxNathiraat->payment_type == 'electronic payment'){
                        $boxNathiraat->bond_state = 'deposited';
                        $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxNathiraat->deposit_date = Carbon::now();
                        if($boxNathiraat->bond_type == "spend"){
                            $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                        }
                        else if($boxNathiraat->bond_type == "take"){
                            $this->generalBox( $boxNathiraat->total_money,0 , Carbon::now());
                        }
                    }
                    if($boxNathiraat->payment_type == 'cash' && $boxNathiraat->bond_type == "spend"){
                        $boxNathiraat->bond_state = 'deposited';
                        $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxNathiraat->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                    }
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

