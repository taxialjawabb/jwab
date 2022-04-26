<?php

namespace App\Http\Controllers\Admin\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class ManageTaskController extends Controller
{
    public function add_show()
    {
        return view('tasks.manage_tasks.addTask');
    }

    public function user_department(Request $request)
    {
        $users = Admin::select(['id','name'])->where('department',$request->department)->get();

        return response()->json($users);
    }

    public function add_task(Request $request)
    {
        $request->validate([            
            'department' => 'required|string|in:management,technical',
            'user_id' => 'required|integer',
            'subject' =>      'required|string',
            'description' =>'required|string',
        ]);
        // return $request->all();

        $task =  Task::create([
            'department' => $request->department,
            'readed_by' => $request->user_id,
            'add_by' => Auth::guard('admin')->user()->id,
            'subject' => $request->subject,
            'content' => $request->description,
            'state' => 'unseen',
            'created_at' => Carbon::now(),
        ]);;
       
        // return dd($task);
        
        $request->session()->flash('status', 'تم أضافة المهمة بنجاح');

        return back();
    }

    public function show_tasks($state)
    {
        if($state == 'unseen' || $state == 'seen' || $state == 'uncomplete'  ){
            $tasks = DB::select("select tasks.id, tasks.department, ad1.name as add_admin, subject, content,
            tasks.state, tasks.created_at, readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
                            from tasks left join admins ad1 on tasks.add_by = ad1.id left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? ;" , [$state]);
        return view('tasks.manage_tasks.showTasks', compact('tasks', 'state'));
    }
    else{
        return back();
    }
        
    }
    
    public function show_complete_tasks($state)
    {
        if($state == 'complete' ){
            $tasks = DB::select("select tasks.id, tasks.department, ad1.name as add_admin, subject, content,
            tasks.state, tasks.created_at, readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
                            from tasks left join admins ad1 on tasks.add_by = ad1.id left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? ;" , [$state]);
                            
        return view('tasks.manage_tasks.showTasks', compact('tasks', 'state'));
    }
    else{
        return back();
    }
        
    }

    public function make_uncomplate($id)
    {

        $task =Task::find($id);
        // return $task;
        if($task !== null ){
            $task->state = 'uncomplete';
            $task->save();
        }
        return back();
    }
}