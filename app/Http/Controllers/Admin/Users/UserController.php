<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class UserController extends Controller
{
    public function user_block($id)
    {
        $user = Admin::find($id);
        if($user != null){
            if($user->state === "active"){
                $user->state = "blocked";
                session()->flash('status', 'تم أستبعاد المستخدم بنجاح');
            }
            else if($user->state === "blocked"){
                $user->state = "active";
                session()->flash('status', 'تم إلغاء الأستبعاد للمستخدم بنجاح');
            }
            $user->save();
        }
        return back();
    }
}
