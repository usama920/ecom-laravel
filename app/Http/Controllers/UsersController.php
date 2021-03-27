<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{
    public function userLoginRegister() {
        return view('wayshop.users.login_register');
    }

    public function register(Request $request) {
        if($request->isMethod('post')) {
            $data=$request->all();
            //echo "<pre>";print_r($data);die();
            $userCount=User::where(['email'=>$data['email']])->count();
            if($userCount>0) {
                return redirect()->back();
            } else {
                $user = new User();
                $user->name=$data['name'];
                $user->email=$data['email'];
                $user->password=bcrypt($data['password']);
                $user->save();

                //Send Register User Email
              //  $email=$data['email'];
               // $messageData=['email'=>$data['email'],'name'=>$data['name']];
                //Mail::send('wayshop.email.register', $messageData, function ($message) use ($email) {
               //     $message->to($email)->subject('Account Registration for Wayshop');
               // });

                //Confrimation Email
                $email=$data['email'];
                $messageData=['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('wayshop.email.confirm', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Account Activation for Wayshop');
                });
                return redirect()->back();

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    $request->session()->put('frontSession', $data['email']);
                    if(!empty($request->session()->get('session_id'))) {
                        $session_id=$request->session()->get('session_id');
                        DB::table('cart')->where(['session_id'=>$session_id])->update(['email'=>$email]);   
                    }
                    return redirect('/cart');
                }
            }
        }
    }

    public function logout(Request $request) {
        $request->session()->forget('frontSession');
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data=$request->all();
            if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $userStatus=User::where(['email' => $data['email']])->first();
                if($userStatus->status==0) {
                    return redirect()->back();
                }
                $request->session()->put('frontSession', $data['email']);
                if(!empty($request->session()->get('session_id'))) {
                    $session_id=$request->session()->get('session_id');
                    DB::table('cart')->where(['session_id'=>$session_id])->update(['email'=>$email]);   
                }
                return redirect('/cart');
            } else {
                return redirect()->back();
            }
        }
    }

    public function confirmAccount($email)
    {
        $email=base64_decode($email);
        $userCount=User::where(['email'=>$email])->count();
        if($userCount>0) {
            $userDetails=User::where(['email'=>$email])->first();
            if($userDetails->status==1) {
                return redirect('/login-register');
            } else {
                User::where(['email'=>$email])->update(['status'=>1]);
                //Send Welcom to Users
                $messageData=['email'=>$email,'name'=>$userDetails->name];
                Mail::send('wayshop.email.welcome', $messageData, function ($message) use($email) {
                    $message->to($email);
                });
                return redirect('/login-register');
            }
        }else {
            abort(404);
        }
    }
    public function account() {
            //echo "<pre>";print_r(Session('frontSession'));die();
        return view('wayshop.users.account');
    }

    public function changePassword(Request $request)
    {
        if($request->isMethod('post')) {
            $data=$request->all();
            $old_pwd=User::where(['id'=>Auth::user()->id])->first();
            $currentPassword=$data['current_password'];
            if(Hash::check($currentPassword, $old_pwd->password)) {
                $new_pwd=bcrypt($data['new_pwd']);
                User::where(['id'=>Auth::user()->id])->update(['password'=>$new_pwd]);
                return redirect('/account');
            } else {
                return redirect()->back();
            }
        }
        return view('wayshop.users.change_password');
    }

    public function changeAddress(Request $request)
    {
        $user_id=Auth::user()->id;
        $userDetails=User::find($user_id);
        if($request->isMethod('post')) {
            $data=$request->all();
            $user=User::find($user_id);
            $user->name=$data['name'];
            $user->address=$data['address'];
            $user->city=$data['city'];
            $user->state=$data['state'];
            $user->country=$data['country'];
            $user->pincode=$data['pincode'];
            $user->mobile=$data['mobile'];
            $user->save();
            return redirect()->back();
        }
        //echo "<pre>";print_r($userDetails);die();
        $countries=Country::get();
        return view('wayshop.users.change_address')->with(compact('countries','userDetails'));
    }
}
