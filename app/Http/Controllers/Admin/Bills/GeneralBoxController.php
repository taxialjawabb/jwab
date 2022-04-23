<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralBox;

class GeneralBoxController extends Controller
{
    public function show_general_box()
    {
        $deposits =DB::select("
                        (select admins.name, date(deposit_date) as deposit_date, bank_account_number , bond_type , sum(total_money) as money, count(box_vechile.id) as count_bill, payment_type from box_vechile left join  admins on box_vechile.deposited_by = admins.id where box_vechile.bond_state = 'deposited'group by bank_account_number, bond_type,date(deposit_date), admins.name, payment_type)
                        UNION ALL 
                        (select admins.name, date(deposit_date) as deposit_date, bank_account_number,bond_type , sum(total_money) as money, count(box_driver.id)  as count_bill, payment_type from box_driver , admins where (deposited_by= admins.id and bond_state = 'deposited') group by bank_account_number, bond_type,date(deposit_date), admins.name, payment_type)
                        UNION ALL 
                        (select admins.name, date(deposit_date) as deposit_date, bank_account_number,bond_type , sum(total_money) as money, count(box_rider.id)  as count_bill, payment_type from box_rider , admins where (deposited_by= admins.id and bond_state = 'deposited') group by bank_account_number, bond_type,date(deposit_date), admins.name, payment_type)
                       UNION ALL 
                       (select admins.name, date(deposit_date) as deposit_date, bank_account_number,bond_type , sum(total_money) as money, count(box_user.id)  as count_bill, payment_type from box_user , admins where (deposited_by= admins.id and bond_state = 'deposited') group by bank_account_number, bond_type,date(deposit_date), admins.name, payment_type)
                       UNION ALL 
                        (select admins.name, date(deposit_date) as deposit_date, bank_account_number,bond_type , sum(total_money) as money, count(box_nathriaat.id)  as count_bill, payment_type from box_nathriaat , admins where (deposited_by= admins.id and bond_state = 'deposited') group by bank_account_number, bond_type,date(deposit_date), admins.name, payment_type);
               
                        ");
        $generalBox = GeneralBox::find(1);

        // for ($i=0; $i < count($deposits); $i++) { 
        //     if($deposits[$i]->bond_type === 'take'){
        //         $take += $deposits[$i]->money;
        //     }
        //     else if($deposits[$i]->bond_type === 'spend'){
        //         $spend += $deposits[$i]->money;
        //     }
        // }
        return view('bills.generalBox', compact('deposits', 'generalBox'));
    }
}
