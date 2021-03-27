<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Admins;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request) {
        if($request->isMethod('post')){
            $data=$request->input();
            $adminCount=Admin::where(['username'=>$data['username'],'password'=>md5($data['password']),'status'=>1])->count();
            if($adminCount>0) {
                $request->session()->put('adminSession', $data['username']);
                return redirect('/admin/dashboard');
            } else {
                session()->flash('Error','Invalid Username or Password');
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard() {
        return view('admin.dashboard');
    }

    public function logout(Request $request) {
        $request->session()->forget('adminSession');
        $request->session()->forget('session_id');
        session()->flash('Error','You have been logged out');
    }

    public function changePassword(Request $request)
    {
        $userDetail=Admin::where(['status'=>1])->first();
        if($request->isMethod('post')) {
            $data=$request->all();
            $adminCount=Admin::where(['username'=>$request->session()->get('adminSession'),'password'=>md5($data['current_pwd']),'status'=>1])->count();
            //echo $adminCount;die;
            if($adminCount>0) {
                $new_pwd=md5($data['new_pwd']);
                Admin::where(['username'=>$request->session()->get('adminSession')])->update(['password'=>$new_pwd,'username'=>$data['username']]);
                return redirect()->back();
            } else {
                return redirect('/admin/dashboard');
            }
        }
        return view('admin.user_profile');
    }
}
