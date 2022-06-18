<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DriverVechile;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\Vechile\BoxVechile;
use App\Models\Driver\DriverNotes;
use Illuminate\Support\Facades\Auth;
use  App\Models\Covenant\CovenantItem;
use App\Models\Covenant\CovenantRecord;

class DriverController extends Controller
{
    public function show_driver($state = null)
    {
        $drivers ;
        $title = 'عرض بيانات السائقين';
        if($state === 'active' || $state === 'waiting' || $state === 'blocked' || $state === 'pending'){
            $drivers = DB::select('select driver.id, driver.name, driver.phone,driver.state, vechile.vechile_type, vechile.made_in, vechile.plate_number, driver.add_date, admins.name as admin_name, 
            ROUND((driver.driver_rate + vechile_rate + time_rate) / (driver_counter+vechile_counter+time_counter) , 1) as rate
            from driver left join vechile on driver.current_vechile = vechile.id left join admins on driver.admin_id = admins.id where driver.state = ?;',[$state]);
            $title = 'عرض بيانات السائقين ال'.$this->driverState($state);
        }
        else{
            $drivers = DB::select("select driver.id, driver.name, driver.phone,driver.state, vechile.vechile_type, vechile.made_in, vechile.plate_number, driver.add_date, admins.name as admin_name,
            ROUND((driver.driver_rate + vechile_rate + time_rate) / (driver_counter+vechile_counter+time_counter) , 1) as rate
            from driver left join vechile on driver.current_vechile = vechile.id left join admins on driver.admin_id = admins.id where driver.state != 'pending';");
        }
        return view('driver.showDriver', compact('drivers', 'title'));
    }
    public function show_add()
    {
        return view('driver.addDriver');
    }
    public function add_driver(Request $request)
    {
        $driverData = Driver::where('ssd', $request->ssd)->orWhere('phone', $request->phone)->get();
        if(count($driverData) > 0 ){
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
            return back();    
        }
        else{
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->password = '0' ;
            $driver->nationality = $request->nationality;
            $driver->ssd = $request->ssd;
            $driver->address = $request->address;
            $driver->id_copy_no = $request->id_copy_no;
            $driver->id_expiration_date = $request->id_expiration_date;
            $driver->license_type = $request->license_type;
            $driver->license_expiration_date = $request->license_expiration_date;
            $driver->birth_date = $request->birth_date;
            $driver->start_working_date = $request->start_working_date;
            $driver->contract_end_date = $request->contract_end_date;
            $driver->final_clearance_date = $request->final_clearance_date;
            $driver->phone = $request->phone;
            $driver->admin_id = Auth::guard('admin')->user()->id;
            $driver->add_date = Carbon::now();
        
        if($request->hasFile('image')){
            $file = $request->file('image');
			$name = $file->getClientOriginalName();
			$ext  = $file->getClientOriginalExtension();
			$size = $file->getSize();
			$mim  = $file->getMimeType();
			$realpath = $file->getRealPath();
			$image = time().'.'.$ext;
			$file->move(public_path('images/drivers/personal_phonto'),$image);
			$driver->persnol_photo =  $image;
	
		}
        $driver->save();
        $request->session()->flash('status', 'تم إضافة السائق بنجاح');
        return back();    
    }
    }
    public function detials($id){
        $driver = Driver::select(['id', 'name',  'available', 'nationality', 'ssd',
            'address', 'id_copy_no', 'id_expiration_date', 'license_type', 
            'license_expiration_date', 'birth_date', 'start_working_date', 
            'contract_end_date', 'final_clearance_date', 'persnol_photo', 
            'current_vechile', 'add_date', 'admin_id', 'state', 'email', 
            'email_verified_at', 'phone', 'phone_verified_at', 
            'remember_token', 'created_at', 'updated_at', 
            'account', 
            DB::raw(" ROUND((driver.driver_rate / driver_counter ) , 1) as driver_rate,
            ROUND(( vechile_rate  / vechile_counter) , 1) as vechile_rate,
            ROUND(( time_rate / time_counter) , 1) as time_rate")
        ])->find($id);
        $vechile = null;
        if($driver->current_vechile !== null){
            $vechile = DB::select('select 
                                    vechile.id,
                                    vechile.vechile_type,
                                    vechile.made_in,
                                    vechile.serial_number,
                                    vechile.plate_number,
                                    vechile.color,
                                    vechile.driving_license_expiration_date,
                                    vechile.insurance_card_expiration_date,
                                    vechile.periodic_examination_expiration_date,
                                    vechile.operating_card_expiry_date,
                                    vechile.add_date,
                                    vechile.state,
                                    driver.name,
                                    driver.phone,
                                    admins.name as admin_name,
                                    category.category_name,
                                    secondary_category.name
                                    from vechile left join category on vechile.category_id = category.id
                                    left join driver on vechile.id = driver.current_vechile 
                                    left join admins on vechile.admin_id = admins.id
                                    left join secondary_category on vechile.secondary_id = secondary_category.id  where vechile.id = ? limit 1;', [$driver->current_vechile]);
            $vechile = $vechile[0];
        }

        
        return view('driver.detials', compact('driver' , 'vechile'));
    }

    public function update_show($id){
        $driver = Driver::find($id);
        if($driver !== null){
            return view('driver.updateDriver', compact('driver'));
        }
        else{
            return redirect('driver/show');
        }
    }
    public function update_driver(Request $request){
        $request->validate([ 
            'id' =>'required',
            'name' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'id_expiration_date' => 'required',
            'license_type' => 'required',
            'license_expiration_date' => 'required',
            'birth_date' => 'required',
            'start_working_date' => 'required',
            'contract_end_date' => 'required',
            'final_clearance_date' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $driver = Driver::find($request->id);
        
        if($driver !== null){
            $drv = DB::select('select id from driver where id != ? and (phone = ? )', [$request->id,$request->phone]);
            if(count($drv) > 0){
                $request->session()->flash('error', 'رقم الهاتف موجود بالفعل');
                return back();    
            }

            $driver->name = $request->name;
            $driver->nationality = $request->nationality;
            $driver->address = $request->address;
            $driver->id_expiration_date = $request->id_expiration_date;
            $driver->license_type = $request->license_type;
            $driver->license_expiration_date = $request->license_expiration_date;
            $driver->birth_date = $request->birth_date;
            $driver->start_working_date = $request->start_working_date;
            $driver->contract_end_date = $request->contract_end_date;
            $driver->final_clearance_date = $request->final_clearance_date;
            $driver->phone = $request->phone;
            
            if($request->hasFile('image')){
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/drivers/personal_phonto'),$image);
                $driver->persnol_photo =  $image;
        
            }
            $driver->save();
            $request->session()->flash('status', 'تم إضافة السائق بنجاح');
            return back();    
        }else{
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();    
        }
    }
    public function vechiles($id)
    {
        $vechiles = DB::select('select vechile.vechile_type, vechile.plate_number, vechile.made_in, start_date_drive, end_date_drive, reason
        from driver, vechile,  driver_vechile where driver.id=driver_vechile.driver_id and vechile.id= driver_vechile.vechile_id and  driver.id = ?;', [$id]);
        return view('driver.vechilesForDriver', compact('vechiles'));
    }
    public function show_state($id)
    {
        $covenants = DB::select('select covenant_items.id, covenant_items.covenant_name, 
        covenant_items.serial_number, covenant_items.state , covenant_items.delivery_date
        from covenant_items where current_driver = ?', [$id]);
        return view('driver.stateDriver', compact('id', 'covenants'));
        
    }
    public function save_state(Request $request){
        // return Auth::guard('admin')->user()->hasPermission('user_delivery_covenant');
        $userCovenants =  CovenantRecord::where('forign_type', 'user')
        ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get(); 
        if(count($userCovenants) == 0){
            $request->session()->flash('error', 'خطاء لا يوجد مستخدم مستلم العهد  ');
            return back(); 
        }
        else if($userCovenants[0]->forign_id !== Auth::guard('admin')->user()->id){
            $request->session()->flash('error', 'يجب ان يكون مستخدم مستلم العهدة هو من يقوم بتسلم العهد ');
            return back(); 
        }

        $driver = Driver::find($request->id);

        
        if($request->has('item')){
            if(count($request->item) != $request->length){
                session()->flash('error', 'يجب تسلم جميع العهد المسلمة');
                return back(); 
            }
            $prevUserReceive =  CovenantRecord::where('forign_type', 'user')
                    ->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();
            $adminDelivery = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;
            foreach ($request->item as $itemId) {
                $record = CovenantRecord::where('forign_type','driver')->where('forign_id', $request->id)
                                        ->where('item_id', $itemId)->where('receive_date', null)
                                        ->where('receive_by', null)->get();
                $covenantItem = CovenantItem::find($itemId);
                if($covenantItem!== null){
                    $covenantItem->current_driver = null ;
                    $covenantItem-> state = 'waiting' ;
                    $covenantItem-> delivery_date = null;
            
                    $covenantItem->save();
                }
                if(count($record)> 0){
                    $record[0]->receive_date = Carbon::now();
                    $record[0]->receive_by = Auth::guard('admin')->user()->id;
                    $record[0]->save();
                }
                if($adminDelivery !== null){
                    $covenantRecord  = new  CovenantRecord;
                    $covenantRecord->forign_type = 'user';
                    $covenantRecord->forign_id = $adminDelivery->forign_id;
                    $covenantRecord->item_id = $covenantItem->id;
                    $covenantRecord->delivery_date = Carbon::now();
                    $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;
                    $covenantRecord->save();
                }
            }
        }
        if($driver !== null ){
        //check if driver has vechile now
        $prefVechile = Vechile::find($driver->current_vechile);
        if($prefVechile){
            //change vechile state and the time campany back vechile
            $prefVechile->state = 'waiting';
            $prefDriverVechile =  DriverVechile::where('vechile_id', $prefVechile->id)->where('driver_id', $driver->id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
            ->limit(1)->get();
            
            if(count($prefDriverVechile) > 0){
                //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$prefVechile->id]);

                    $daysDriverHasVechile = $prefDriverVechile[0]->start_date_drive->diffInDays(Carbon::now()->addDay());
                    $payedRegister    = $prefDriverVechile[0]->payedRegister ;
                    $daysNotRegister = $daysDriverHasVechile - $payedRegister ;

                    if($daysNotRegister > 0){
                        $addMoney = $prefVechile->daily_revenue_cost * $daysNotRegister;
                        
                        $boxVechile = new BoxVechile;
                        $boxVechile->vechile_id = $prefVechile->id;
                        $boxVechile->foreign_type = 'driver';
                        $boxVechile->foreign_id = $driver->id;
                        $boxVechile->bond_type = 'take';
                        $boxVechile->payment_type = 'internal transfer';
                        $boxVechile->money = $addMoney;
                        $boxVechile->tax = 0;
                        $boxVechile->total_money = $addMoney;
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->descrpition = 'ايام لم يتم تسجلها بشكل يوم عدد الايام ' .$daysNotRegister .'المبالغ المضاف : ' .$addMoney;
                        $boxVechile->add_date = Carbon::now();

                        $driver->account -=  $addMoney;
                        $prefVechile->account =$prefVechile->account +($addMoney);                
                        $prefDriverVechile[0]->payedRegister = $daysDriverHasVechile;                 
                        $boxVechile->save();
                        }
                    
                
                $prefDriverVechile[0]->end_date_drive = Carbon::now();
                $prefDriverVechile[0]->admin_id = Auth::guard('admin')->user()->id;                
                $prefDriverVechile[0]->reason ='تغير حالة السائق من' . $driver->state .'الى'. $request->state;                
                $prefDriverVechile[0]->save();
            }
            $prefVechile->save();
            }
            $note = new DriverNotes;
            $note->driver_id = $request->id;
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();
            $note->note_type ='تغير حالة السائق من' . $driver->state .'الى'. $request->state;
            $driver->state = $request->state;
            $driver->current_vechile = null;
            $note->content = $request->reason;
            $driver->save();
            $note->save();
            $request->session()->flash('status', 'تم تغير حالة السائق بنجاح');

            return redirect('driver/details/'.$request->id);

        }else{
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back(); 
        }

    }

    public function show_take($id)
    {
        $waitingVechiles = Vechile::select(['id','vechile_type', 'made_in','plate_number', 'color'])->where('state','waiting')->get();
        $driver = Driver::find($id);
        if($driver->state === 'active'){
            session()->flash('error', 'يجب تسلم المركبة اولا وتحويل حالة السائق انتظار');
            return back(); 
        }
        if(count($waitingVechiles) > 0 && $driver !== null ){
            $allCovenant =   \App\Models\Covenant\Covenant::all();

            return view('driver.takeVechile', compact('waitingVechiles', 'driver', 'allCovenant'));
        }else{
            session()->flash('error', 'لا يوجد مركبات متاحة الأن');
            return back(); 
        }
        
    }
    public function save_take(Request $request){
        $request->validate([ 
            'driver_id' =>'required|integer',
            'vechile_id' => 'required|integer',
            'daily_revenue_cost' => 'required|numeric'
        ]); 
        $userCovenants =  CovenantRecord::where('forign_type', 'user')
        ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get(); 
        if(count($userCovenants) == 0){
            $request->session()->flash('error', 'خطاء لا يوجد مستخدم مستلم العهد  ');
            return back(); 
        }
        else if($userCovenants[0]->forign_id !== Auth::guard('admin')->user()->id){
            $request->session()->flash('error', 'يجب ان يكون مستخدم مستلم العهدة هو من يقوم بتسليم العهد ');
            return back(); 
        }
        if($request->has('covenant_item')){
            foreach ($request->covenant_item as $item) {
                $prevUserReceive =  CovenantRecord::where('item_id', $item)
                ->where('forign_type', 'user')
                ->where('receive_date', null)->get();
                $adminDelivery = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;
                
                if($adminDelivery !== null){
                    $adminDelivery->receive_date = Carbon::now();
                    $adminDelivery->receive_by = Auth::guard('admin')->user()->id;
                    $adminDelivery->save();
                }
                $covenantItem = CovenantItem::find($item);
                if($covenantItem !== null){
                    $covenantItem->current_driver = $request->driver_id ;
                    $covenantItem-> state = 'active' ;
                    $covenantItem-> delivery_date = Carbon::now();

                    
                    $covenantRecord  = new CovenantRecord;
                    $covenantRecord->forign_type = 'driver';
                    $covenantRecord->forign_id = $request->driver_id;
                    $covenantRecord->item_id = $item;
                    $covenantRecord->delivery_date = Carbon::now();
                    $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;
        
                    $covenantItem->save();
                    $covenantRecord->save();
                    
                    $request->session()->flash('status', 'تم تسليم العهد للسائق  نجاح');
                }
            }
        }

        $driver = Driver::find($request->driver_id);
        
        
        if($driver === null){
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back(); 
        }

        $totalMoneyAddForDriver= 0;
        //check if driver has vechile now
        $prefVechile = Vechile::find($driver->current_vechile);
        if($prefVechile !== null){
            //change vechile state and the time campany back vechile
            $prefVechile->state = 'waiting';
            $prefDriverVechile =  DriverVechile::where('vechile_id', $prefVechile->id)->where('driver_id', $driver->id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
            ->limit(1)->get();

            if(count($prefDriverVechile) > 0){
                //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$prefVechile->id]);
                    $daysDriverHasVechile = $prefDriverVechile[0]->start_date_drive->diffInDays(Carbon::now()->addDay());
                    $payedRegister    = $prefDriverVechile[0]->payedRegister ;
                    $daysNotRegister = $daysDriverHasVechile - $payedRegister ;

                    if($daysNotRegister > 0){
                        $addMoney = $prefVechile->daily_revenue_cost * $daysNotRegister;
                        
                        $boxVechile = new BoxVechile;
                        $boxVechile->vechile_id = $prefVechile->id;
                        $boxVechile->foreign_type = 'driver';
                        $boxVechile->foreign_id = $driver->id;
                        $boxVechile->bond_type = 'take';
                        $boxVechile->payment_type = 'internal transfer';
                        $boxVechile->money = $addMoney;
                        $boxVechile->tax = 0;
                        $boxVechile->total_money = $addMoney;
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->descrpition = 'ايام لم يتم تسجلها بشكل يوم عدد الايام ' .$daysNotRegister .'المبالغ المضاف : ' .$addMoney;
                        $boxVechile->add_date = Carbon::now();

                        $totalMoneyAddForDriver +=  $addMoney;
                        $prefVechile->account =$prefVechile->account +($addMoney);                
                        $prefDriverVechile[0]->payedRegister = $daysDriverHasVechile;                 
                        $boxVechile->save();
                        }
                    
                    
                $prefDriverVechile[0]->end_date_drive = Carbon::now();
                $prefDriverVechile[0]->admin_id = Auth::guard('admin')->user()->id;                
                $prefDriverVechile[0]->reason = 'تغير السيارة و استلام سيارة اخرى';                
                $prefDriverVechile[0]->save();
            }
            $prefVechile->save();
        }
        $vechile = Vechile::find($request->vechile_id);
        if($vechile !== null){
            
            $driverVechile1 = new DriverVechile;
            $driverVechile1->vechile_id = $vechile->id;
            $driverVechile1->driver_id = $driver->id;
            $driverVechile1->start_date_drive = Carbon::now();
            $driverVechile1->payedRegister = 1;
            $driverVechile1->admin_id = Auth::guard('admin')->user()->id;
            $driverVechile1->save();
            
            $vechile->state = 'active';
            $vechile->save();
            
            $driver->state = 'active';
            $driver->current_vechile = $vechile->id;
            
            //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$vechile->id]);
            
                $boxVechile = new BoxVechile;
                $boxVechile->vechile_id = $vechile->id;
                $boxVechile->foreign_type = 'driver';
                $boxVechile->foreign_id = $driver->id;
                $boxVechile->bond_type = 'take';
                $boxVechile->payment_type = 'internal transfer';
                $boxVechile->money = $request->daily_revenue_cost;
                $boxVechile->tax = 0;
                $boxVechile->total_money = $request->daily_revenue_cost;
                $boxVechile->bond_state = 'deposited';
                $boxVechile->descrpition = 'عائد يومى للمركبة ' .$vechile->id .' على السائق ' . $driver->name;
                $boxVechile->add_date = Carbon::now();
                $totalMoneyAddForDriver +=  $request->daily_revenue_cost;
                $vechile->account =$vechile->account +  $request->daily_revenue_cost;
                $vechile->daily_revenue_cost = $request->daily_revenue_cost;
                
                $boxVechile->save();
                $vechile->save();
            
            $driver->account -=$totalMoneyAddForDriver;
            $driver->save();
            $request->session()->flash('status', 'تم تسليم مركبة للسائق');
            return redirect('driver/details/'.$driver->id);
            // return dd($vechile); 
        }
        else{
            $request->session()->flash('error', 'خطاء فى البيانات ');
            return redirect('driver/details/'.$request->id);
        }

    }
    public function availables()
    {
        $drivers = Driver::select(['id', 'name', 'phone'])->where('available', true)->get();
        return view('driver.availbleDriver', compact('drivers'));
    }
    
    public function driver_active($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $driver->state = 'waiting';
            $driver->save();
        }
        return back();
    }

    public function show_report(Request $request)
    {
        $search = '';
        if($request->has('from_date') && $request->has('to_date')){
            $search = " and date(box_driver.add_date) BETWEEN '".$request->from_date."' AND '".$request->to_date."' ";
        }
        $sql = "
        select driver.id, driver.name, driver.phone ,sum(box_driver.total_money)  as total
           from driver , box_driver where driver.id = box_driver.driver_id and  
           box_driver.bond_type = 'take'
           ".$search."
           group by driver.id;
       ";
        $data = DB::select($sql);

        // return $data;

        return view('driver.reports.showReports', compact('data'));
    }

    public function show_debits(){
        $data = Driver::select(['id', 'name', 'phone', 'account'])
        ->where('account','<=', -5000)->orderBy('account' , 'asc')->get();
        return view('driver.reports.showDebits', compact('data'));
        
    }

    



}