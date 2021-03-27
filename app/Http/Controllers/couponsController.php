<?php

namespace App\Http\Controllers;

use App\Coupons;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class couponsController extends Controller
{
    public function addCoupon(Request $request)
    {
        if($request->isMethod('post')) {
            $data=$request->all();
            $coupon = new Coupons();
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->amount=$data['coupon_amount'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->save();
            return redirect('/admin/add-coupon');
        }
        return view('admin.coupons.edit_coupon');
    }

    public function viewCoupons() {
        $coupons=Coupons::get();
        return view('admin.coupons.view_coupon')->with(compact('coupons'));
    }

    public function updateStatus(Request $request) {
        $data=$request->all();
        Coupons::where(['id'=>$data['id']])->update(['status'=>$data['status']]);
    }

    public function editCoupon(Request $request,$id)
    {
        if($request->isMethod('post')) {
            $data=$request->all();
            $coupon = Coupons::find($id);
            $coupon->coupon_code=$data['coupon_code'];
            $coupon->amount=$data['coupon_amount'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->save();
            return redirect('/admin/view-coupons');
        }
        $couponDetails=Coupons::find($id);
        return view('admin.coupons.edit_coupon')->with(compact('couponDetails'));
    }

    public function deleteCoupon($id)
    {
        Coupons::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully');
        return redirect()->back();
    }

    
}
