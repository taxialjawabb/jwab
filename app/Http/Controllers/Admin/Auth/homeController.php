<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect('control/panel/login');
    }
    public function home()
    {
        $admin = Auth::guard('admin') -> user();
        
        if($admin !== null){
            return view('home');
        }
        else{
            return back();
        }
    }
}
