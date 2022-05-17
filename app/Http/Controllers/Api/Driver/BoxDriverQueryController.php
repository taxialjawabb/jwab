<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;

class BoxDriverQueryController extends Controller
{
    use GeneralTrait;

    public function get_bonds(Request $request)
    {
        $first = DB::table('box_vechile')
            ->select(
                'box_vechile.id',
                'box_vechile.payment_type',
                'box_vechile.money',
                'box_vechile.tax',
                'box_vechile.total_money',
                'box_vechile.descrpition',
                'box_vechile.add_date',
                DB::raw("IF(box_vechile.bond_type = 'spend', 'take', 'spend') as bond_type")
            )
            ->where('box_vechile.foreign_type','driver')
            ->where('box_vechile.foreign_id',$request->driver_id);

        $data = DB::table('box_driver')
        ->select(
            'box_driver.id',
            'box_driver.payment_type',
            'box_driver.money',
            'box_driver.tax',
            'box_driver.total_money',
            'box_driver.descrpition',
            'box_driver.add_date',
            'box_driver.bond_type'
            // DB::raw( "IF(box_driver.bond_type = 'spend', 'take', 'spend') as bond_type")
            )
        ->where('box_driver.driver_id', $request->driver_id)
            ->union($first)->orderBy('add_date', 'desc')
            ->paginate(10);

            if(count($data)>0){
                return  $this -> returnData('bonds' , $data, 'list of bonds') ;
            }
            else{
                return $this->returnError('E001', "Driver do not have bonds");
            }
    }

    public function trips(Request $request)
    {
        $request->validate([
            'driver_id' =>'required',
            ]);
        $trip = DB::table('trips')->select([
                "trips.id",
                "trips.state",
                "trips.trip_type",
                "trips.start_loc_latitude",
                "trips.start_loc_longtitude",
                "trips.start_loc_name",
                "trips.end_loc_name",
                "trips.reqest_time",
                "trips.trip_time",
                "trips.payment_type",
                "trips.cost",
                "driver.name",
                "vechile.plate_number",
                "rider.name",
                "rider.phone"
            ])
        ->leftJoin('driver', 'trips.driver_id', '=', 'driver.id')
        ->leftJoin('vechile', 'vechile.id', '=',  'driver.current_vechile')
        ->leftJoin('rider', 'rider.id', '=', 'trips.rider_id')
        ->where('driver_id',$request->driver_id)
        ->where('trips.state','!=', 'canceled')
        ->orderBy('reqest_time', 'desc')
        ->paginate(10);
        if($trip){
            return $this->returnSuccessMessage($trip);
        }else{
            return $this->returnError('E003', 'there is no trips');
        }
        
    }
}
