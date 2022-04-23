<?php

namespace App\Http\Controllers\Admin\Driver\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Driver\DriverNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NotesDriverController extends Controller
{
    public function show_note($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $notes = DB::select(' select notes_driver.id, note_type, content, add_date, attached, admins.name as admin_name from notes_driver left join admins 
                                    on notes_driver.admin_id = admins.id where driver_id= ?;', [$id]);
            return view('driver.notes.showNotesDriver', compact('notes','driver'));
        }else{
            return redirect('driver/show');
        }
    }
    public function show_add($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            return  view('driver.notes.addNotesDriver', compact('driver'));
        }else{
            return redirect('driver/show');
        }
    }
    public function add_note(Request $request)
    {
        $request->validate([            
            'driver_id' =>     'required|integer',
            'notes_type' =>  'required|string',
            'content' =>        'required|string',
            //'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            
        ]);
        $driver = Driver::find($request->driver_id);
        if($driver !== null){
           $note = new DriverNotes;
           $note->note_type = $request->notes_type;
           $note->content = $request->content;
           $note->add_date = Carbon::now();
           $note->admin_id = Auth::guard('admin')->user()->id;
           $note->driver_id = $request->driver_id;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/drivers/notes'),$image);
                
               $note->attached = $image;
            }
           $note->save();
            $request->session()->flash('status', 'تم اضافة ملاحظة للسائق');
            return redirect('driver/notes/show/'.$request->driver_id);
        }else{
            return redirect('driver/show');
        }
    }
}
