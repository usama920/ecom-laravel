<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Country;
use App\Products;
use App\Coupons;
use App\DeliveryAddress;
use App\Orders;
use App\OrdersProducts;
use App\ProductsAttributes;
use App\ProductsImages;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function GuzzleHttp\json_decode;

class ProductsController extends Controller
{
    public function addProduct(Request $request) {
        if($request->isMethod('post')) {
            $data=$request->all();
            $product= new Products();
            $product->name=$data['product_name'];
            $product->category_id=$data['category_id'];
            $product->code=$data['product_code'];
            $product->color=$data['product_color'];
            $product->price=$data['product_price'];

            if(!empty($data['product_description'])) {
                $product->description=$data['product_description'];
            } else {
                $product->description='';
            }
            if($request->hasFile('image')) {
                $img_tmp= $data['image'];
                $extension=$img_tmp->getClientOriginalExtension();
                $filename=rand(1111,9999999).'.'.$extension;
                $img_path='uploads/products/'.$filename;
                Image::make($img_tmp)->resize(500,500)->save($img_path);
                $product->image=$filename;
            }
            $product->save();
            return redirect('/admin/view-products');

        }
        $categories= Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option value='' selected disabled>Select</option>";
        foreach($categories as $cat) {
            $categories_dropdown.="<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown.="<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProducts() {
        $products=Products::paginate(3);
        return view('admin.products.view-products')->with(compact('products'));
    }

    public function editProduct(Request $request,$id) {
        if($request->IsMethod('post')) {
            $data=$request->all();
            if($request->hasFile('image')) {
                $img_tmp= $data['image'];
                $extension=$img_tmp->getClientOriginalExtension();
                $filename=rand(1111,9999999).'.'.$extension;
                $img_path='uploads/products/'.$filename;
                Image::make($img_tmp)->resize(500,500)->save($img_path);
            } else {
                $filename=$data['current_image'];
            }
            if(empty($data['product_description'])) {
                $data['product_description']='';
            }
            Products::where(['id'=>$id])->update(['name'=>$data['product_name'],'category_id'=>$data['category_id'],'code'=>$data['product_code'],'color'=>$data['product_color'],'description'=>$data['product_description'],'price'=>$data['product_price'],'image'=>$filename]);
            return redirect('/admin/view-products');
        }
        $productDetails=Products::where(['id'=>$id])->first();
        //Catgories Dropdown
        $categories= Category::where(['parent_id'=>0])->get();
        $categories_dropdown="<option value='' selected disabled>Select</option>";
        foreach($categories as $cat) {
            if($cat->id==$productDetails->category_id) {
                $selected="selected";
            } else {
                $selected="";
            }
            $categories_dropdown.="<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                $categories_dropdown.="<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        return view('admin.products.edit-product')->with(compact('productDetails','categories_dropdown'));
    }

    public function deleteProduct($id) {
        Products::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully','Success Message');
        return redirect()->back();
    }

    public function updateStatus(Request $request) {
        $data=$request->all();
        //dd($data);
        Products::where(['id'=>$data['id']])->update(['status'=>$data['status']]);
    }

    public function products($id) {
        $productDetails=Products::with('attributes')->where(['id'=>$id])->first();
        $productsAltImages=ProductsImages::where(['product_id'=>$id])->get();
        $featuredProducts=Products::where(['featured_products'=>1])->get();
        return view('wayshop.product_details')->with(compact('productDetails','productsAltImages','featuredProducts'));
    }

    public function addAttributes(Request $request,$id){   
        if($request->isMethod('post')) {
            $data=$request->all();
            //echo "<pre>";
            //print_r($data);
           // die();
            foreach($data['sku'] as $key=>$val) {
                if(!empty($val)) {
                    //Prevent suplicate SKU Record
                    $attrCountSKU=ProductsAttributes::where(['sku'=>$val])->count();
                    if($attrCountSKU>0) {
                        return redirect('/admin/add-attributes/'.$id);
                    }
                    //Prevent suplicate size Record
                    $attrCountSizes=ProductsAttributes::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSizes>0) {
                        return redirect('/admin/add-attributes/'.$id);
                    }
                    $attribute = new ProductsAttributes();
                    $attribute->product_id=$id;
                    $attribute->sku=$val;
                    $attribute->size=$data['size'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->save();
                }

            }
            return redirect('/admin/view-products');
        }
        $productDetails=Products::with('attributes')->where(['id'=>$id])->first();
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function deleteAttributes($id){
        ProductsAttributes::where(['id'=>$id])->delete();
        Alert::success('Attribute Deleted Successfully');
        return redirect()->back();
    }

    public function editAttributes(Request $request, $id) {
        if($request->isMethod('post')) {
            $data=$request->all();
            foreach($data['attr'] as $key=>$attr) {

                ProductsAttributes::where(['id'=>$data['attr'][$key]])->update(['sku'=>$data['sku'][$key], 'size'=>$data['size'][$key], 'price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
            }
        return redirect()->back();
        }
    }

    public function addImages(Request $request, $id){
        if($request->isMethod('post')) {
            $data=$request->all();
            
            if($request->hasFile('image')) {
                $files=$request->image;
                foreach($files as $file) {
                    $image=new ProductsImages();
                    $extension=$file->getClientOriginalExtension();
                    $filename=rand(1111,9999).'.'.$extension;
                    $image_path="uploads/products/".$filename;
                    Image::make($file)->save($image_path);
                    $image->image=$filename;
                    $image->product_id=$data['product_id'];
                    $image->save();
                }
            }
            return redirect('/admin/add-images/'.$id);
        }
        $productDetails=Products::where(['id'=>$id])->first();
        $productImages=ProductsImages::where(['product_id'=>$id])->get();
        return view('admin.products.add_images')->with(compact('productDetails','productImages'));
    }

    public function deleteAltImages($id){
        $productImage=ProductsImages::where(['id'=>$id])->first();
        $image_path='uploads/products/';
        if(file_exists($image_path.$productImage->image)) {
            unlink($image_path.$productImage->image);
        }
        ProductsImages::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully');
        return redirect()->back();
    }

    public function updateFeatured(Request $request) {
        $data=$request->all();
        Products::where(['id'=>$data['id']])->update(['featured_products'=>$data['status']]);
    }

    public function getprice(Request $request){
        $data=$request->all();
        //echo "<pre>";
        //print_r($data);
        //die();
        $proArr=explode('--',$data['idSize']);
        $proAttr=ProductsAttributes::where(['product_id'=>$proArr[0],'size'=>$proArr[1]])->first();
        echo $proAttr->price;
    }

    public function addtoCart(Request $request)
    {
        $request->session()->forget('CouponAmount');
        $request->session()->forget('CouponCode');
        if($request->isMethod('post')) {
            $data=$request->all();
            //echo "<pre>";print_r($data);die();
            if(empty(Auth::user()->email)) {
                $data['user_email']='';
            } else {
                $data['user_email']=Auth::user()->email;
            }
            $session_id=$request->session()->get('session_id');
            if(empty($session_id)) {
                $session_id = Str::random(40);
                $request->session()->put('session_id',$session_id);
            }
            $sizeArr=explode('--',$data['size']);
            $countProducts = DB::table('cart')->where(['product_id'=>$data['product_id'],'product_code'=>$data['product_code'],'size'=>$sizeArr[1],'price'=>$data['price'],'session_id'=>$session_id])->count();
            if ($countProducts>0) {
                return redirect()->back();
            }else {
            DB::table('cart')->insert(['product_id'=>$data['product_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['color'],'size'=>$sizeArr[1],'price'=>$data['price'],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
            return redirect('/cart');
            }
        }
    }

    public function cart(Request $request) {
        if(Auth::check()) {
            $user_email=Auth::user()->email;
            $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else {
            $session_id=$request->session()->get('session_id');
            $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
        foreach($userCart as $key=>$products) {
            $productDetails = Products::where(['id'=>$products->product_id])->first();
            $userCart[$key]->image=$productDetails->image;
        }
           //echo "<pre>";print_r($userCart);die();
        return view('wayshop.products.cart')->with(compact('userCart'));
    }

    public function deleteCartProduct(Request $request,$id)
    {
        $request->session()->forget('CouponAmount');
        $request->session()->forget('CouponCode');
        DB::table('cart')->where(['id'=>$id])->delete();
        return redirect()->back();
    }

    public function updateCartQuantity(Request $request,$id,$quantity)
    {
        $request->session()->forget('CouponAmount');
        $request->session()->forget('CouponCode');
        DB::table('cart')->where(['id'=>$id])->increment('quantity',$quantity);
        return redirect()->back();
    }

    public function applyCoupon(Request $request)
    {
        $request->session()->forget('CouponAmount');
        $request->session()->forget('CouponCode');
        if($request->isMethod('post')) {
            $data=$request->all();
            $couponCount=Coupons::where(['coupon_code'=>$data['coupon_code']])->count();
            if($couponCount==0) {
                return redirect()->back();
            } else {
                $couponDetails=Coupons::where(['coupon_code'=>$data['coupon_code']])->first();
                if($couponDetails->status==0) {
                return redirect()->back();
                }
                $expiry_date=$couponDetails->expiry_date;
                $current_date=date('Y-m-d');
                if($expiry_date<$current_date) {
                    return redirect()->back();
                }
                //Ready For discount
                $session_id=$request->session()->get('session_id');
                if(Auth::check()) {
                    $user_email=Auth::user()->email;
                    $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
                }else {
                    $session_id=$request->session()->get('session_id');
                    $userCart=DB::table('cart')->where(['session_id'=>$session_id])->get();
                }
                $totalAmount=0;
                foreach($userCart as $item) {
                    $totalAmount=$totalAmount+($item->price*$item->quantity);
                }
                //Check if coupon amount is fixed or percentage
                if($couponDetails->amount_type=='Fixed') {
                    $couponAmount=$couponDetails->amount;
                } else {
                    $couponAmount=$totalAmount * ($couponDetails->amount/100);
                    $couponAmount=intval($couponAmount);
                }
                //Add coupon code in session
                $request->session()->put('CouponAmount', $couponAmount);
                $request->session()->put('CouponCode', $data['coupon_code']);
                return redirect()->back();
                
            }
        }
    }

    public function checkout(Request $request)
    {
        $user_id=Auth::user()->id;
        $user_email=Auth::user()->email;
        $shippingDetails=DeliveryAddress::where(['user_id'=>$user_id])->first();
        $userDetails=User::find($user_id);
        $countries=Country::get();
        //check if shipping address exists
        $shippingCount=DeliveryAddress::where(['user_id'=>$user_id])->count();
        $shippingDetails=array();
        if($shippingCount>0) {
            $shippingDetails=DeliveryAddress::where(['user_id'=>$user_id])->first();
        }
        //Update cart table with email
       // $session_id=$request->session()->get('session_id');
        //DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);
        if($request->isMethod('post')) {
            $data=$request->all();
            //echo"<pre>";print_r($user_id);die;
            //Update User Details
            User::where(['id'=>$user_id])->update(['name'=>$data['billing_name'],'address'=>$data['billing_address'],'city'=>$data['billing_city'],'state'=>$data['billing_state'],'pincode'=>$data['billing_pincode'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile']]);

            if($shippingCount>0) {
                DeliveryAddress::where(['user_id'=>$user_id])->update(['name'=>$data['shipping_name'],'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'state'=>$data['shipping_state'],'pincode'=>$data['shipping_pincode'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']]);
            } else {
                // New Shipping Address
                $shipping = new DeliveryAddress();
                $shipping->user_id=$user_id;
                $shipping->user_email=$user_email;
                $shipping->name=$data['shipping_name'];
                $shipping->address=$data['shipping_address'];
                $shipping->city=$data['shipping_city'];
                $shipping->state=$data['shipping_state'];
                $shipping->pincode=$data['shipping_pincode'];
                $shipping->country=$data['shipping_country'];
                $shipping->mobile=$data['shipping_mobile'];
                $shipping->save();
            }
            return redirect()->action('ProductsController@orderReview');
        }
        return view('wayshop.products.checkout')->with(compact('userDetails','countries','shippingDetails'));
    }

    public function orderReview() {
        $user_id=Auth::user()->id;
        $user_email=Auth::user()->email;
        $shippingDetails=DeliveryAddress::where(['user_id'=>$user_id])->first();
        $userDetails=User::find($user_id);
        $userCart=DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach($userCart as $key=>$product) {
            $productDetails=Products::where(['id'=>$product->product_id])->first();
            $userCart[$key]->image=$productDetails->image;
        }
        return view('wayshop.products.order_review')->with(compact('userDetails','shippingDetails','userCart'));
    }

    public function placeOrder(Request $request) {
        if($request->isMethod('post')) {
            $user_id=Auth::user()->id;
            $user_email=Auth::user()->email;
            $data=$request->all();

            //Get Shipping Details of user
            $shippingDetails=DeliveryAddress::where(['user_email'=>$user_email])->first();
            if(empty($request->session()->get('CouponCode'))) {
                $coupon_code='';
            }else {
                $coupon_code=$request->session()->get('CouponCode');
            }
            if(empty($request->session()->get('CouponAmount'))) {
                $coupon_amount='0';
            } else {
                $coupon_amount=$request->session()->get('CouponAmount');
            }

            $order= new Orders();
            $order->user_id=$user_id;
            $order->user_email=$user_email;
            $order->name=$shippingDetails->name;
            $order->address=$shippingDetails->address;
            $order->city=$shippingDetails->city;
            $order->state=$shippingDetails->state;
            $order->pincode=$shippingDetails->pincode;
            $order->country=$shippingDetails->country;
            $order->mobile=$shippingDetails->mobile;
            $order->coupon_code=$coupon_code;
            $order->coupon_amount=$coupon_amount;
            $order->order_status="New";
            $order->payment_method=$data['payment_Method'];
            $order->grand_total=$data['grandTotal'];
            $order->save();

            $order_id=DB::getPdo()->lastinsertID();
            $cartProducts=DB::table('cart')->where(['user_email'=>$user_email])->get();

            foreach($cartProducts as $pro) {
                $cartPro=new OrdersProducts();
                $cartPro->order_id=$order_id;
                $cartPro->user_id=$user_id;
                $cartPro->product_id=$pro->product_id;
                $cartPro->product_code=$pro->product_code;
                $cartPro->product_name=$pro->product_name;
                $cartPro->product_color=$pro->product_color;
                $cartPro->product_size=$pro->size;
                $cartPro->product_price=$pro->price;
                $cartPro->product_qty=$pro->quantity;
                $cartPro->save();   
            }
            $request->session()->put('order_id', $order_id);
            $request->session()->put('grand_total', $data['grandTotal']);
            if($data['payment_Method']=="cod") {
                
                $productDetails= Orders::with('orders')->where(['id'=>$order_id])->first();
                $productDetails=json_decode(json_encode($productDetails),true);

                $userDetails = User::where(['id'=>$user_id])->first();
                $userDetails=json_decode(json_encode($userDetails),true);

                //Send email for codorder
                $email=$user_email;
                $messageData = [
                    'email'=> $email, 
                    'name'=> $shippingDetails->name, 
                    'order_id' => $order_id,
                    'productDetails' => $productDetails,
                    'userDetails' => $userDetails
                ];
                Mail::send('wayshop.email.cod', $messageData, function ($message) use($email) {
                    $message->to($email)->subject('Your Wayshoporder is placed');
                });
                return redirect('/thanks');
            } else {
                return redirect('/stripe');
            }
        }
    }

    public function thanks() {
        $user_email=Auth::user()->email;
        DB::table('cart')->where(['user_email'=>$user_email])->delete();
        return view('wayshop.orders.thanks');
    }

    public function stripe(Request $request) {
        if($request->isMethod('post')) {
            $data=$request->all();
            \Stripe\Stripe::setApiKey('sk_test_51HrIs7FtvvCwpQsa2KxmcxrTjaCoTfWOo2Y2flQaj81NKNbmy8KZZffzC5blQyH7NYwHJTttxR5hBgpwDiEdDFTI00ZskxU6s6');
            $token=$_POST['stripeToken'];
            $charge=\Stripe\charge::Create([
                'amount' => $request->input('total_amount')*100,
                'currency' => 'pkr',
                'description' => $request->input('name'),
                'source' => $token,
            ]);
            //dd($charge);
            return redirect()->back();
        }
        return view('wayshop.orders.stripe');
    }

    public function userOrders() {
        $user_id=Auth::user()->id;
        $orders=Orders::with('orders')->where(['user_id'=>$user_id])->orderBy('id','DESC')->get();
        //echo "<pre>";print_r($orders);die;
        return view('wayshop.orders.user_orders')->with(compact('orders'));
    }

    public function userOrderDetails($order_id) {
        $orderDetails=Orders::with('orders')->where(['id'=>$order_id])->first();
        $user_id=$orderDetails->user_id;
        $userDetails=User::where(['id'=>$user_id])->first();
        return view('wayshop.orders.user_order_details')->with(compact('orderDetails','userDetails'));
    }

    public function viewOrders() {
        $orders=Orders::with('orders')->orderBy('id','DESC')->get();
        return view('admin.orders.view_orders')->with(compact('orders'));
    }

    public function viewOrderDetails($order_id) {
        $orderDetails=Orders::with('orders')->where(['id'=>$order_id])->first();
        $user_id=$orderDetails->user_id;
        $userDetails=User::where(['id'=>$user_id])->first();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails'));
    }

    public function updateOrderStatus(Request $request) {
        if($request->isMethod('post')) {
            $data=$request->all();
        }
        Orders::where(['id'=>$data['order_id']])->update(['order_status'=>$data['order_status']]);
        return redirect()->back();
    }

    public function viewCustomers() {
        $userDetails=User::get();
        return view('admin.users.customers')->with(compact('userDetails'));
    }

    public function updateCustomerStatus(Request $request) {
        $data=$request->all();
        User::where(['id'=>$data['id']])->update(['status'=>$data['status']]);
    }

    public function deleteCustome($id)
    {
        User::where(['id'=>$id])->delete();
        Alert::success('Deleted Successfully');
        return redirect()->back();
    }

    public function orderInvoice($order_id)
    {
        $orderDetails=Orders::with('orders')->where(['id'=>$order_id])->first();
        $user_id=$orderDetails->user_id;
        $userDetails=User::where(['id'=>$user_id])->first();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
}