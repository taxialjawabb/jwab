<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        // return dd(Auth::guard('admin')->user());
        if(!Auth::guard('admin')->check())
        {
            // do what you need to do
            return view('admin.login');
        }else{
            return redirect('/home');
        }
    }
    public function login_admin(Request $request){
        $credentials = $request->validate([
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);


        if (Auth::guard('admin')->attempt($credentials)) {
            if(Auth::guard('admin')->user()->state ==="active"){
                $request->session()->regenerate();
                return redirect('home');
            }
            else{
                Auth::guard('admin')->logout();
                return abort(403, 'تم حظر هذا المستخدم  .');
            }
        }

        return back();
    }

    
}
