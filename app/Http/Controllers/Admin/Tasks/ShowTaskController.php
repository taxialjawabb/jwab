<?php

namespace App\Http\Controllers\Admin\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks\Task;
use App\Models\Tasks\Result;

class ShowTaskController extends Controller
{
    public function show($id)
    {
        $task = Task::find($id);
        if($task !== null){
            $results = Result::select(['add_date' , 'content'])->where('task_id' , $id)->orderBy('add_date','desc')->get();
            // return dd($results);
            return view('tasks.detialsTask', compact('task', 'results'));
        }
        else{
            return back();
        }
    }
}
