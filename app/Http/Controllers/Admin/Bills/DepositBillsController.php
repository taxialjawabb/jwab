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

class DepositBillsController extends Controller
{
    public function show_bills($type)
    {
        switch ($type) {
            case 'vechile':

                $final_deposited = DB::select("select  admins.name, bond_type, count(box_vechile.id) as bill_count, sum(total_money) as total_money, payment_type
                                    from box_vechile, admins where (bond_state = 'trustworthy' and trustworthy_by = admins.id and (box_vechile.payment_type ='cash' ) and bond_type = 'take') group by  admins.name ,  payment_type , bond_type;");
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_vechile where bond_state = 'trustworthy'  and (box_vechile.payment_type ='cash' )  and bond_type = 'take' group by bond_type;");
                $bills = DB::select("select box_vechile.id from box_vechile ,driver, admins where (box_vechile.confirm_by = admins.id and box_vechile.bond_state = 'trustworthy'  and (box_vechile.payment_type ='cash' )  and bond_type = 'take') and box_vechile.foreign_id = driver.id and box_vechile.foreign_type ='driver' 
                            UNION
                            select box_vechile.id from box_vechile ,rider, admins where (box_vechile.confirm_by = admins.id and box_vechile.bond_state = 'trustworthy'  and (payment_type ='cash' )  and bond_type = 'take') and  box_vechile.foreign_id = rider.id and box_vechile.foreign_type ='rider' 
                            UNION
                            select box_vechile.id from box_vechile, admins where (box_vechile.confirm_by = admins.id and  box_vechile.bond_state = 'trustworthy'  and  (payment_type ='cash' )  and bond_type = 'take') and  box_vechile.foreign_type ='vechile' ;");
                return view('bills.billsWaitingDeposit', compact('bills', 'type', "totalBond", 'final_deposited'));
                break;            
            case 'driver':
                $final_deposited = DB::select("select  admins.name, bond_type, count(box_driver.id) as bill_count, sum(total_money) as total_money, payment_type
                                    from box_driver, admins where (bond_state = 'trustworthy' and trustworthy_by = admins.id and  (payment_type ='cash' ) and bond_type = 'take') group by  admins.name ,  payment_type , bond_type;");
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_driver where bond_state = 'trustworthy' and  (payment_type ='cash' )  and bond_type = 'take' group by bond_type;");
                $bills = DB::select("select box_driver.id  from box_driver , driver, admins  where (box_driver.confirm_by = admins.id and bond_state = 'trustworthy' and (payment_type ='cash' ) and bond_type = 'take') and box_driver.driver_id = driver.id ;");
                return view('bills.billsWaitingDeposit', compact('bills', 'type', "totalBond", 'final_deposited'));
                break;
            case 'rider':
                $final_deposited = DB::select("select  admins.name, bond_type, count(box_rider.id) as bill_count, sum(total_money) as total_money, payment_type
                                    from box_rider, admins where (bond_state = 'trustworthy' and trustworthy_by = admins.id and  (payment_type ='cash' ) and bond_type = 'take') group by  admins.name ,  payment_type , bond_type;");
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_rider where bond_state = 'trustworthy' and  (payment_type ='cash' )  and bond_type = 'take' group by bond_type;");
                $bills = DB::select("select box_rider.id  from box_rider , rider, admins  where (box_rider.confirm_by = admins.id and bond_state = 'trustworthy' and (payment_type ='cash' ) and bond_type = 'take') and box_rider.rider_id = rider.id ;");
                return view('bills.billsWaitingDeposit', compact('bills', 'type', "totalBond", 'final_deposited'));
                break;
            
                case 'user':
                    $final_deposited = DB::select("select  admins.name, bond_type, count(box_user.id) as bill_count, sum(total_money) as total_money, payment_type
                                        from box_user, admins where (bond_state = 'trustworthy' and trustworthy_by = admins.id and  (payment_type ='cash' ) and bond_type = 'take') group by  admins.name ,  payment_type , bond_type;");
                    $totalBond = DB::select(" select bond_type, sum(money) as money from box_user where bond_state = 'trustworthy' and  (payment_type ='cash' )  and bond_type = 'take' group by bond_type;");
                    $bills = DB::select("select box_user.id  from box_user , admins as user, admins as ad  where (box_user.confirm_by = ad.id and bond_state = 'trustworthy' and (payment_type ='cash' ) and bond_type = 'take') and box_user.user_id = user.id ;");
                    return view('bills.billsWaitingDeposit', compact('bills', 'type', "totalBond", 'final_deposited'));
                break;

            case 'nathiraat':
                $final_deposited = DB::select("select  admins.name, bond_type, count(box_nathriaat.id) as bill_count, sum(total_money) as total_money, payment_type
                                    from box_nathriaat, admins where (bond_state = 'trustworthy' and trustworthy_by = admins.id and (payment_type ='cash' )  and bond_type = 'take') group by  admins.name ,  payment_type , bond_type;");
                $totalBond = DB::select(" select bond_type, sum(money) as money from box_nathriaat where bond_state = 'trustworthy' and payment_type ='cash' and bond_type = 'take' group by bond_type;");
                $bills = DB::select("select box_nathriaat.id from box_nathriaat , admins where box_nathriaat.add_by = admins.id and bond_state = 'trustworthy' and  (payment_type ='cash' )  and bond_type = 'take';");
                return view('bills.billsWaitingDeposit', compact('bills', 'type', "totalBond", 'final_deposited'));
                break;
            default:
                return redirect('vechile/show');
                break;
        }
    }

    public function deposit_bills(Request $request)
    {
        // return dd($request->all());
        if($request->id === null){
            return back();
        }
        switch ($request->type) {
            case 'vechile':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxVechile= BoxVechile::find($request->id[$i]);
                    $boxVechile->bond_state = 'deposited';
                    $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxVechile->deposit_date = Carbon::now();
                    $boxVechile->bank_account_number = $request->bank_account_number;
                    if($boxVechile->bond_type == "spend"){
                        $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                    }
                    else if($boxVechile->bond_type == "take"){
                        $this->generalBox( $boxVechile->total_money,0 , Carbon::now());
                    }
                    $boxVechile->save();
                }
                return back();
                break;
            case 'driver':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxDriver= BoxDriver::find($request->id[$i]);
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxDriver->deposit_date = Carbon::now();
                    $boxDriver->bank_account_number = $request->bank_account_number;
                    if($boxDriver->bond_type == "spend"){
                        $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                    }
                    else if($boxDriver->bond_type == "take"){
                        $this->generalBox( $boxDriver->total_money,0 , Carbon::now());
                    }
                    $boxDriver->save();
                }
                return back();
                break;
            case 'rider':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxRider= BoxRider::find($request->id[$i]);
                    $boxRider->bond_state = 'deposited';
                    $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxRider->deposit_date = Carbon::now();
                    $boxRider->bank_account_number = $request->bank_account_number;
                    if($boxRider->bond_type == "spend"){
                        $this->generalBox(0, $boxRider->total_money , Carbon::now());
                    }
                    else if($boxRider->bond_type == "take"){
                        $this->generalBox( $boxRider->total_money,0 , Carbon::now());
                    }
                    $boxRider->save();
                }
                return back();
                break;
                
                case 'user':
                    for ($i=0; $i < count($request->id); $i++) { 
                        $boxUser= BoxUser::find($request->id[$i]);
                        $boxUser->bond_state = 'deposited';
                        $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxUser->deposit_date = Carbon::now();
                        $boxUser->bank_account_number = $request->bank_account_number;
                        if($boxUser->bond_type == "spend"){
                            $this->generalBox(0, $boxUser->total_money , Carbon::now());
                        }
                        else if($boxUser->bond_type == "take"){
                            $this->generalBox( $boxUser->total_money,0 , Carbon::now());
                        }
                        $boxUser->save();
                    }
                    return back();
                break;

            case 'nathiraat':
                for ($i=0; $i < count($request->id); $i++) { 
                    $boxNathiraat= BoxNathriaat::find($request->id[$i]);
                    $boxNathiraat->bond_state = 'deposited';
                    $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxNathiraat->deposit_date = Carbon::now();
                    $boxNathiraat->bank_account_number = $request->bank_account_number;
                    if($boxNathiraat->bond_type == "spend"){
                        $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                    }
                    else if($boxNathiraat->bond_type == "take"){
                        $this->generalBox( $boxNathiraat->total_money,0 , Carbon::now());
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
