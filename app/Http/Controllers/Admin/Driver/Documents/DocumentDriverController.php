<?php

namespace App\Http\Controllers\Admin\Driver\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Driver\DriverDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentDriverController extends Controller
{
    public function show_document($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $documents = DB::select('select documents_driver.id, document_type, content, add_date, attached, admins.name as admin_name from documents_driver left join admins on documents_driver.admin_id = admins.id  where driver_id=?;', [$id]);
            return view('driver.documents.showDocsDriver', compact('documents','driver'));
        }else{
            return redirect('driver/show');
        }
    }
    public function show_add($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            return  view('driver.documents.addDocsDriver', compact('driver'));
        }else{
            return redirect('driver/show');
        }
    }
    public function add_document(Request $request)
    {
        $request->validate([            
            'driver_id' =>     'required|integer',
            'document_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $driver = Driver::find($request->driver_id);
        if($driver !== null){
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/drivers/documents'),$image);
                $document = new DriverDocuments;
                $document->document_type = $request->document_type;
                $document->content = $request->content;
                $document->add_date = Carbon::now();
                $document->admin_id = Auth::guard('admin')->user()->id;
                $document->driver_id = $request->driver_id;
                $document->attached = $image;
                $document->save();
                $request->session()->flash('status', 'تم اضافة مستند للسائق');
                return redirect('driver/documents/show/'.$request->driver_id);
            }
        }else{
            return redirect('driver/show');
        }
    }
}

