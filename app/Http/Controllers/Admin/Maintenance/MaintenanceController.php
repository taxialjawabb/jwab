<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceCenter\Product;
use App\Models\MaintenanceCenter\ProductQuantity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function show_products()
    {
        $product = Product::all();
        return view('maintenance.showMaintenance', compact('product'));
    }
    public function show_details($id)
    {
        $quantities = DB::select("
            select products_quantity.id, count, products_quantity.type , products_quantity.add_date , admins.name
            from products_quantity , admins where products_quantity.add_by = admins.id and product_id = ? 
        ", [$id]);
        return view('maintenance.showItemMaintenance', compact('quantities'));
    }
    public function show_add()
    {
        return view('maintenance.addItemMaintenance');
    }
    public function show_update($id)
    {
        $product = Product::find($id);
        if($product !== null){
            return view('maintenance.updateitemMaintenance', compact('product'));
        }else{
            return back();
        }
    }
    public function save_add(Request $request)
    {
        $request->validate([            
            'name' => 'required|string',
            'free_count' => 'required|integer',
            'periodic_days' =>      'required|integer',
            'price' =>'required|integer',
        ]);
        Product::create([
            'name' => $request->name ,
            'total' => 0,
            'stored' => 0,
            'used' => 0,
            'returned' => 0,
            'free_count' => $request->free_count ,
            'periodic_days' => $request->periodic_days ,
            'price' => $request->price ,
            'add_date' => Carbon::now() ,
            'add_by' => Auth::guard('admin')->user()->id,
        ]);
        $request->session()->flash('status', 'تم أضافة الصنف بنجاح');
        
        return redirect('maintenance/center/manage');
    }
    public function save_quantity(Request $request)
    {
        // return $request->all();
        
        $request->validate([            
            'id' => 'required|integer',
            'quantity_name' => 'required|string',
            'quantity' => 'required|integer',
            'type' =>      'required|string',
            'price' =>      'numeric'
        ]);
        $product =  Product::where('id', $request->id)->where('name', $request->quantity_name)->get();
        if(count($product) > 0){
            ProductQuantity::create([
                'product_id'   => $product[0]->id ,
                'count'    => $request->quantity ,
                'type' =>  $request->type,
                'add_date' =>  Carbon::now(),
                'add_by'   => Auth::guard('admin')->user()->id ,
            ]);

            $product[0]->total += $request->quantity;
            if($request->type === 'stored'){
                $product[0]->stored += $request->quantity;
            }
            else if($request->type === 'returned'){
                $product[0]->returned += $request->quantity;
            }
            else  if($request->type === 'used'){
                $product[0]->used += $request->quantity;
            }
            $product[0]->save();
            if($request->has('price') && $request->price > 0){
                $stakeholder = \App\Models\Nathiraat\Stakeholders::find(9);
                $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
                $boxNathriaat->stakeholders_id = 9;
                $boxNathriaat->bond_type = 'spend';
                $boxNathriaat->payment_type = $request->payment_type;
                $boxNathriaat->money = $request->price;
                $boxNathriaat->tax = 0;
                $boxNathriaat->total_money = $request->price;
                $boxNathriaat->bond_state = 'waiting';
                $boxNathriaat->descrpition = 'شراء كمية من: '. $request->quantity_name .' مقدار الكمية هوه : '. $request->quantity;
                $boxNathriaat->add_date = Carbon::now();
                $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
                
                $boxNathriaat->save();
                $stakeholder-> account -= $request->price;
                $stakeholder->save();
            }
            $request->session()->flash('status', 'تم أضافة الكمية إالى الصنف بنجاح');
            return redirect('maintenance/center/manage');
        }else{
            $request->session()->flash('error', 'لم يتم اضافة الصنف ');

            back();
        }
    }
    public function save_update(Request $request)
    {
        $request->validate([            
            'id' => 'required|integer',
            'name' => 'required|string',
            'free_count' => 'required|integer',
            'periodic_days' =>      'required|integer',
            'price' =>'required|integer',
        ]);

        Product::where('id', $request->id)->update([
                'name' => $request->name ,
                'free_count' => $request->free_count ,
                'periodic_days' => $request->periodic_days ,
                'price' => $request->price ,
                'add_date' => Carbon::now() ,
                'add_by' => Auth::guard('admin')->user()->id,
            ]);
        $request->session()->flash('status', 'تم تعديل بيانات الصنف بنجاح');
        
        return redirect('maintenance/center/manage');
    }
}
