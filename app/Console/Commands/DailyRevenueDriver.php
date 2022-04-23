<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Vechile\BoxVechile;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\DriverVechile;

class DailyRevenueDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calaculate daily revenue for active driver has vechile';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $data = DB::select('select driver.id as driver_id , driver.current_vechile ,vechile.id as vechile_id , driver_vechile.start_date_drive, driver_vechile.end_date_drive, category.category_name, category.percentage_type, category.daily_revenue_cost
        // from driver , vechile , driver_vechile, category where driver.id = driver_vechile.driver_id and vechile.id = driver_vechile.vechile_id and category.id = vechile.category_id and driver_vechile.end_date_drive is null and date(driver_vechile.start_date_drive) != CAST(NOW() AS DATE);');
        
        $data = DB::select('select driver.id as driver_id , driver.current_vechile ,vechile.id as vechile_id , driver_vechile.start_date_drive, 
        driver_vechile.end_date_drive, vechile.daily_revenue_cost
        from driver , vechile , driver_vechile
        where driver.id = driver_vechile.driver_id and vechile.id = driver_vechile.vechile_id and
          driver_vechile.end_date_drive is null and date(driver_vechile.start_date_drive) != CAST(NOW() AS DATE);');

        for ($i=0; $i < count($data) ; $i++) { 
            if(Carbon::parse($data[$i]->start_date_drive)->hour === Carbon::now()->hour){
                $boxVechile = new BoxVechile;
                $driver =  Driver::find($data[$i]->driver_id);
                $vechile = Vechile::find($data[$i]->vechile_id);
                $boxVechile->vechile_id = $data[$i]->vechile_id;
                $boxVechile->foreign_type = 'driver';
                $boxVechile->foreign_id = $data[$i]->driver_id;
                $boxVechile->bond_type = 'take';
                $boxVechile->payment_type = 'internal transfer';
                $boxVechile->bond_state = 'deposited';
                $boxVechile->descrpition = 'عائد يومى للمركبة ' .$data[$i]->vechile_id .' على السائق ' . $driver->name;
                $boxVechile->money = $data[$i]->daily_revenue_cost;
                $boxVechile->tax = 0;
                $boxVechile->total_money = $data[$i]->daily_revenue_cost;
                $boxVechile->add_date = Carbon::now();
                $driver->account -=  $data[$i]->daily_revenue_cost;
                $vechile->account +=  $data[$i]->daily_revenue_cost;
                $boxVechile->save();
                $driver->save();
                $vechile->save();

                $driver_vechile =  DriverVechile::where('vechile_id', $data[$i]->vechile_id)->where('driver_id', $data[$i]->driver_id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
                ->limit(1)->get();
                if(count($driver_vechile) > 0){
                    $driver_vechile[0]->payedRegister +=  1;                
                    $driver_vechile[0]->save();
                }
            }
            
        }
        // return dd($data);
    }
}
