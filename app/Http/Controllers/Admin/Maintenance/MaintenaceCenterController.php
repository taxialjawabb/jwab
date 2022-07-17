<?php

namespace App\Http\Controllers\Admin\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceCenter\Product;
use App\Models\MaintenanceCenter\ProductQuantity;
use App\Models\MaintenanceCenter\ProductVechile;
use App\Models\MaintenanceCenter\ProductDelivered;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\Vechile;
use App\Traits\GeneralTrait;

class MaintenaceCenterController extends Controller
{
    use GeneralTrait;

    public function show_bills($id)
    {
        $data = DB::select("
        select products_deliverd.id, products.name,	
        products_deliverd.count, products_deliverd.price,	products_deliverd.driver_id,	
        products_deliverd.vechile_id,	products_deliverd.add_date, admins.name as add_by	
        from products_deliverd , products, admins where products_deliverd.product_id= products.id and products_deliverd.add_by= admins.id and products_deliverd.driver_id = ? ;"
        , [$id]);
        return view('maintenance.showCountMaintenance', compact('data', 'id'));
    }
    public function show_add($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $services = Product::select(['id', 'name'])->where('stored', '>', 0)->get();
            // return $services;
            return view('maintenance.addBillMaintenance', compact('driver', 'services'));
        }
        else{
            return back();
        }
    }
    public function confirm_item(Request $request)
    {
        $driver = Driver::select(['id','current_vechile'])->find($request->driver_id);
        $vechile = Vechile::find($request->vechile_id);
        if($driver !== null && $vechile !== null){
            $product = Product::find($request->service);
            if($request->quantity > $product->stored){
                return $this->returnError('E003', 'لا يوجد كمية كافيه فى المخزن ،  الكمية المتاحه هى : ' . $product->stored);
            }
            if($product !== null){
                $productVechile = ProductVechile::where('product_id', $product->id)->where('vechile_id', $vechile->id)->get();
                if(count($productVechile) === 0){
                    //product_vechile table empty

                    $newProductVechile =  ProductVechile::create([
                        'product_id' => $product->id,
                        'balance_count' => 0 ,
                        'vechile_id' => $vechile->id,
                        'start_date' => Carbon::now(),
                        'end_date' => Carbon::now()->addDays($product->periodic_days),
                        'add_date' => Carbon::now(),
                        'add_by' => Auth::guard('admin')->user()->id 
                    ]);
                    $freeBalance = $product->free_count- $newProductVechile->balance_count;
                    $balance = 0 ;
                    if($freeBalance > 0){
                        $balance = $request->quantity - $freeBalance;
                    }
                    else{
                        $balance = $request->quantity;
                    }

                    $extraPrice = 0;
                    if($balance > 0){
                        $extraPrice = $balance * $product->price;
                        $items = $this->data($product->name, $product->id, $request->quantity, $balance, $product->price, $extraPrice);
                        return $this -> returnData('data' , $items,'');
                    }
                    else{
                        $items = $this->data($product->name, $product->id, $request->quantity, 0, $product->price, $extraPrice);
                        return $this -> returnData('data' , $items,'');
                    }
                }else{
                    $diffDays =  Carbon::now()->diff($productVechile[0]->end_date)->format("%r%a");
                    if( $diffDays > 0){

                        
                        $existProductVechile = $productVechile[0];

                        $freeBalance = $product->free_count- $existProductVechile->balance_count;
                        $balance = 0 ;
                        if($freeBalance > 0){
                            $balance = $request->quantity - $freeBalance;
                        }
                        else{
                            $balance = $request->quantity;
                        }
                        $extraPrice = 0;
                        // return "free=".$product->free_count ."balance=". $existProductVechile->balance_count ."new=".$request->quantity;
                        if($balance > 0){
                            $extraPrice = $balance * $product->price;
                            $items = $this->data($product->name, $product->id, $request->quantity, $balance, $product->price, $extraPrice);                        
                            return $this -> returnData('data' , $items,'');
                        }
                        else{
                            $items = $this->data($product->name, $product->id, $request->quantity, 0, $product->price, $extraPrice);
                            return $this -> returnData('data' , $items,'');
                        }
                    }else{
                        $productVechile[0]->start_date = $productVechile[0]->end_date;
                        $productVechile[0]->end_date = Carbon::now()->addDays($product->periodic_days);
                        $productVechile[0]->balance_count = 0;
                        $productVechile[0]->save();
                        $existProductVechile = $productVechile[0];
                        
                        $freeBalance = $product->free_count- $existProductVechile->balance_count;
                        $balance = 0 ;
                        if($freeBalance > 0){
                            $balance = $request->quantity - $freeBalance;
                        }
                        else{
                            $balance = $request->quantity;
                        }

                        $extraPrice = 0;
                        if($balance > 0){
                            $extraPrice = $balance * $product->price;
                            $items = $this->data($product->name, $product->id, $request->quantity, $balance, $product->price, $extraPrice);                        
                            return $this -> returnData('data' , $items,'');
                        }
                        else{
                            $items = $this->data($product->name, $product->id, $request->quantity, 0, $product->price, $extraPrice);
                            return $this -> returnData('data' , $items,'');
                        }
                    }
                }
            }
            else{
                return $this->returnError('E003', 'هذه الخدمة غير موجودة ');
            }
        }
        else{
            return $this->returnError('E003', 'هذا السائق او المركبة غير موجودة ');

        }
    }


    public function save_item(Request $request)
    {
        $request->validate([            
            'driver_id' => 'required|integer',
            'vechile_id' => 'required|integer',
            'service_id' => 'required|array',
            'quantity' => 'required|array',
            'price' => 'required|array',
            'total_price' =>      'required|numeric'
        ]);
        
        if(count($request->service_id) !== count($request->quantity) && count($request->service_id) !== count($request->price) ){
            return $this->returnError('E003', 'حدث خطئ فى تسجيل بيانات الفاتورة الرجاء تحديث الصفحة والمحاولة مره اخرى ');
            return back();
        }

        $driver = Driver::find($request->driver_id);
        $vechile = Vechile::find($request->vechile_id);
        $description = "عائد لصيانة المركبة لتجاوز الحد المجانى لصيانة بعض الخدمات، ";
        if($driver !== null && $vechile !== null){
            for ($i=0 ; $i <  count($request->service_id); $i++) {
                $products = Product::find($request->service_id[$i]);
                if($request->quantity[$i] > $products->stored )
                {
                    $request->session()->flash('error','لا يوجد كماية كافيه من المخزن '.$products->name .' الكمية المتاحه هى : '. $products->stored);
                    return back();
                }
                if($request->bons[$i] > 0){
                    $description .= $products->name .' الكمية الزائدة: '. $request->bons[$i].' , ';
                }
            }
            for ($i=0; $i <  count($request->service_id); $i++) { 
                $products = Product::find($request->service_id[$i]);
                $productVechile = ProductVechile::where('product_id', $products->id)
                ->where('vechile_id', $vechile->id)->get();
                if(count($productVechile) > 0){
                    $productVechile[0]->balance_count += $request->quantity[$i];
                    $productVechile[0]->save();
                    ProductDelivered::create([
                        'product_id'    => $products->id,
                        'count'     => $request->quantity[$i],
                        'driver_id'     => $request->driver_id,
                        'vechile_id'    => $request->vechile_id,
                        'price'     => $request->price[$i],
                        'add_date'  => Carbon::now(),
                        'add_by'    => Auth::guard('admin')->user()->id
                    ]);
                }
                $products->stored -= $request->quantity[$i];
                $products->used += $request->quantity[$i];
                $products->save();
                
            }
            if($request->total_price > 0){
                $boxDriver = new \App\Models\Driver\BoxDriver;
                $boxDriver->driver_id = $request->driver_id;
                $boxDriver->bond_type = 'spend';
                $boxDriver->payment_type = 'internal transfer';
                $boxDriver->money = $request->total_price;
                $boxDriver->tax = 0;
                $boxDriver->total_money = $request->total_price;
                $boxDriver->bond_state = 'deposited';
                $boxDriver->descrpition = $description;
                $boxDriver->add_date = Carbon::now();
                $boxDriver->add_by = Auth::guard('admin')->user()->id;
                $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                $boxDriver->deposit_date = Carbon::now();
                
                $driver-> account -= $request->total_price;
                $driver->save();
                $boxDriver->save();

                $description .= " على السائق: " .$driver->name . ' صيانة للمركبة: '. $vechile->plate_number;
                $stakeholder = \App\Models\Nathiraat\Stakeholders::find(9);
                $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
                $boxNathriaat->stakeholders_id = 9;
                $boxNathriaat->bond_type = 'take';
                $boxNathriaat->payment_type = 'internal transfer';
                $boxNathriaat->money = $request->total_price;
                $boxNathriaat->tax = 0;
                $boxNathriaat->total_money = $request->total_price;
                $boxNathriaat->bond_state = 'deposited';
                $boxNathriaat->descrpition = $description;
                $boxNathriaat->add_date = Carbon::now();
                $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
                $boxNathriaat->deposited_by =  Auth::guard('admin')->user()->id;
                $boxNathriaat->deposit_date = Carbon::now();
                $boxNathriaat->save();
                $stakeholder-> account += $request->total_price;
                $stakeholder->save();

                
            }
            
            $request->session()->flash('status', 'تم أضافة الصيانة بنجاح ');
            return redirect('maintenance/center/bill/'. $request->driver_id);
        }else{
            $request->session()->flash('error','خطاء فى بيانات السائق او المركبة المستلة له ');
            return back();
        }
    }



    public function data($service , $service_id , $quantity , $bons , $bonsPrice, $price)
    {
        $object = (object) [
                'service' => $service,
                'service_id' => $service_id,
                'quantity' => $quantity,
                'bons' => $bons,
                'bons_price' => $bonsPrice,
                'price' => $price
            ];
        return $object;
        
    }
}

