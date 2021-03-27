<?php

namespace App\Http\Controllers;

use App\Banners;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class BannersController extends Controller
{
    public function banners()
    {
        $bannerDetails=Banners::get();
        return view('admin.banner.banners')->with(compact('bannerDetails'));
    }

    public function addBanner(Request $request)
    {
        if($request->isMethod('post')) {
            $data=$request->all();
            $banner=new Banners();
            $banner->name=$data['banner_name'];
            $banner->text_style=$data['text_style'];
            $banner->sort_order=$data['sort_order'];
            $banner->content=$data['banner_content'];
            $banner->link=$data['link'];

            if($request->hasFile('image')) {
                $img_tmp= $data['image'];
                $extension=$img_tmp->getClientOriginalExtension();
                $filename=rand(1111,9999999).'.'.$extension;
                $img_path='uploads/banners/'.$filename;
                Image::make($img_tmp)->save($img_path);
                $banner->image=$filename;
            }
            $banner->save();
            return redirect('/admin/banners');
        }
        return view('admin.banner.add_banner');
    }

    public function editBanner(Request $request,$id)
    {

        if($request->IsMethod('post')) {
            $data=$request->all();
            if($request->hasFile('image')) {
                $img_tmp= $data['image'];
                $extension=$img_tmp->getClientOriginalExtension();
                $filename=rand(1111,9999999).'.'.$extension;
                $img_path='uploads/banners/'.$filename;
                Image::make($img_tmp)->save($img_path);
            } else if(!empty($data['current_image'])){
                $filename=$data['current_image'];
            } else {
                $filename='';
            }
            Banners::where(['id'=>$id])->update(['name'=>$data['banner_name'],'text_style'=>$data['text_style'],'content'=>$data['banner_content'],'link'=>$data['link'],'sort_order'=>$data['sort_order'],'image'=>$filename]);
            return redirect('/admin/banners');
        }


        $bannerDetail=Banners::where(['id'=>$id])->first();
        return view('admin.banner.edit_Banner')->with(compact('bannerDetail'));
    }

    public function deleteBanner($id) {
        Banners::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully');
        return redirect()->back();
    }

    public function updateStatus(Request $request) {
        $data=$request->all();
        //dd($data);
        Banners::where(['id'=>$data['id']])->update(['status'=>$data['status']]);
    }
}
