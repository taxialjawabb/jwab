<?php

namespace App\Http\Controllers\Admin\Vechile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SecondaryCategory;
use App\Models\Vechile;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Vechile\VechileNotes;
use Illuminate\Support\Facades\Auth;

class VechileController extends Controller
{
    public function show_add()
    {
        $cat= Category::select('id', 'category_name')->get();
        if(count($cat) > 0){
            return view('vechile.vechiles.addVechile', compact('cat'));
        }else{
            return redirect('vechile/show/cagegory');
        }
    }
    public function secondary_category(Request $request)
    {
        $cat = Category::find($request->id);
        $data = $cat->secondary;

        return response()->json($data);
    }

    public function add_vechile(Request $request)
    {

        $request->validate([            
            'vechile_type' => ['required','string'],
            'made_in' => ['required','string'],
            'serial_number' => ['required','string'],
            'plate_number' => ['required','string'],
            'color' => ['required','string'],
            'driving_license_expiration_date' => ['required','date'],
            'insurance_card_expiration_date' => ['required','date'],
            'periodic_examination_expiration_date' => ['required','date'],
            'operating_card_expiry_date' => ['required','date'],
            // 'add_date' => [],
            // 'state' => [],
            // 'admin_id' => [],
            'category_id' => ['required','integer'],
            'secondary_id' => ['required','integer'],
        ]);
        
        
        $vec = Vechile::where('plate_number', $request->plate_number)->
        orWhere('serial_number', $request->serial_number)->get();
        
        if(count($vec) > 0){
            $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
            return back();    
        }
        else{
            $vechile= new Vechile;
            $vechile->vechile_type = $request-> vechile_type;
            $vechile->made_in = $request-> made_in;
            $vechile->serial_number = $request-> serial_number;
            $vechile->plate_number = $request-> plate_number;
            $vechile->color = $request-> color;
            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;
            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            $vechile->add_date = Carbon::now();
            $vechile->state = 'waiting';
            $vechile->admin_id =  Auth::guard('admin')->user()->id;
            $vechile->category_id = $request-> category_id;
            $vechile->secondary_id = $request-> secondary_id;
            $vechile->save();
            $request->session()->flash('status', 'تم إضافة المركبة بنجاح');
            return back();    
        }
    }

    public function show_vechile($state = null)
    {
        $vechiles ;
        $title = 'عرض بيانات المركبات';
        if($state === 'active' || $state === 'waiting' || $state === 'blocked'){
            $vechiles = DB::select('select  vechile.id, vechile_type, made_in, plate_number, vechile.add_date, driver.name, driver.phone, admins.name as admin_name
                                    from vechile left join driver on vechile.id = driver.current_vechile left join admins on vechile.admin_id = admins.id where vechile.state = ?;',[$state]);
            $title = 'عرض بيانات المركبات ال'.$this->vechileState($state);
        }
        else{
            $vechiles = DB::select('select  vechile.id, vechile_type, made_in, plate_number, vechile.add_date, driver.name, driver.phone, admins.name as admin_name 
                                    from vechile left join driver on vechile.id = driver.current_vechile left join admins on vechile.admin_id = admins.id;');
        }

        return view('vechile.vechiles.showVechile', compact('vechiles', 'title'));
    }

    public function detials($id)
    {     
        $vechile = DB::select(' select 
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
                                left join secondary_category on vechile.secondary_id = secondary_category.id  where vechile.id = ? limit 1;', [$id]);
        $vechile = $vechile[0];
        return view('vechile.vechiles.detials', compact('vechile'));
    }
    public function update_show($id)
    {     
        $vechile = Vechile::find($id);
        if($vechile !== null){
            $cat= Category::select('id', 'category_name')->get();
            $secondary = SecondaryCategory::find($vechile->secondary_id);

            return view('vechile.vechiles.updateVechile', compact('vechile','cat', 'secondary'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function update_vechile(Request $request)
    {
        // return dd($request->all());
        $request->validate([            
            'id' => ['required','integer'],
            'vechile_type' => ['required','string'],
            'made_in' => ['required','string'],
            'serial_number' => ['required','string'],
            'plate_number' => ['required','string'],
            'color' => ['required','string'],
            'driving_license_expiration_date' => ['required','date'],
            'insurance_card_expiration_date' => ['required','date'],
            'periodic_examination_expiration_date' => ['required','date'],
            'operating_card_expiry_date' => ['required','date'],
            'category_id' => ['required','integer'],
            'secondary_id' => ['required','integer'],
            'daily_revenue_cost' => ['required', 'numeric'],
            'maintenance_revenue_cost' => ['required', 'numeric'],
            'identity_revenue_cost' => ['required', 'numeric'],

        ]);
        $vechile = Vechile::find($request->id);
        
        
        if($vechile !== null){
            $vec = DB::select('select id from vechile where id != ? and (serial_number= ? or plate_number = ? )', [$request->id,$request->serial_number, $request->plate_number]);
            if(count($vec) > 0){
                $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
                return back();    
            }

            $vechile->vechile_type = $request-> vechile_type;
            $vechile->made_in = $request-> made_in;
            $vechile->serial_number = $request-> serial_number;
            $vechile->plate_number = $request-> plate_number;
            $vechile->color = $request-> color;
            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;
            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            $vechile->category_id = $request-> category_id;
            $vechile->secondary_id = $request-> secondary_id;
            $vechile->daily_revenue_cost = $request->daily_revenue_cost;
            $vechile->maintenance_revenue_cost = $request->maintenance_revenue_cost;
            $vechile->identity_revenue_cost = $request->identity_revenue_cost;

            $vechile->save();               
            $request->session()->flash('status', 'تم تعديل بيانات المركبة بنجاح');
            return back();    
        }else{
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();    
        }
    }

    public function drivers($id)
    {
        $drivers = DB::select(' select driver.name, driver.phone, driver.nationality, start_date_drive, end_date_drive, reason
        from vechile, driver, driver_vechile where vechile.id= driver_vechile.vechile_id and driver.id=driver_vechile.driver_id and vechile.id =?;', [$id]);
        return view('vechile.vechiles.driversForVechile', compact('drivers'));
    }

    public function show_state($id)
    {
        return view('vechile.vechiles.stateVechile', compact('id'));
        
    }
    public function save_state(Request $request){
        $vechile = Vechile::find($request->id);
        if($vechile !== null){
            $note = new VechileNotes;
            $note->vechile_id = $request->id;
            $note->admin_id =  Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();
            $note->note_type ='تغير حالة السائق من' . $vechile->state .'الى'. $request->state;
            $vechile->state = $request->state;
            $note->content = $request->reason;
            $vechile->save();
            $note->save();
            $request->session()->flash('status', 'تم تغير حالة المركبة بنجاح');
    
            return redirect('vechile/details/'.$request->id);
        }
        else{
            $request->session()->flash('error', 'حدث خطاء ما فى تغير حالة المركبة');
    
            return redirect('vechile/show');
        }

    }

    
}
