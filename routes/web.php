<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'IndexController@index');
Route::get('/home', 'IndexController@index');
Route::get('/products/{id}', 'ProductsController@products');
Route::get('/categories/{category_id}', 'IndexController@categories');
Route::get('/get-product-price', 'ProductsController@getprice');
// Route for Login and register
Route::get('/login-register', 'UsersController@userLoginRegister');
Route::post('/user-login', 'UsersController@login');
Route::post('/user-register', 'UsersController@register');
Route::get('/user-logout', 'UsersController@logout');
Route::get('/confirm/{code}', 'UsersController@confirmAccount');



// Route for add to cart
Route::match(['get', 'post'], 'add-cart', 'ProductsController@addtoCart');
// Route for add to cart
Route::match(['get', 'post'], '/cart', 'ProductsController@Cart');
// Route for delete cart product
Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');
// Route for update quantity
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');
//Aply coupon code
Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');

//Route for middleware after login
Route::group(['middleware'=>['frontlogin']], function () {
    Route::match(['get', 'post'], '/account', 'UsersController@account');
    Route::match(['get', 'post'], '/change-password', 'UsersController@changePassword');
    Route::match(['get', 'post'], '/change-address', 'UsersController@changeAddress');
    Route::match(['get', 'post'], '/checkout', 'ProductsController@checkout');
    Route::match(['get', 'post'], '/order-review', 'ProductsController@orderReview');
    Route::match(['get', 'post'], '/place-order', 'ProductsController@placeOrder');
    Route::match(['get', 'post'], '/stripe', 'ProductsController@stripe');

    Route::get('/thanks','ProductsController@thanks');
    Route::get('/orders','ProductsController@userOrders');
    Route::get('/orders/{id}','ProductsController@userOrderDetails');

});


//Route::get('/home', 'HomeController@index')->name('home');


//Route::match(['get', 'post'], '/', 'IndexController@index');
Route::match(['get', 'post'], '/admin', 'AdminController@login');
Route::group(['middleware' => ['AdminLogin']], function () {
    Route::match(['get', 'post'], '/admin/dashboard', 'AdminController@dashboard');
    Route::match(['get', 'post'], '/admin/user-profile', 'AdminController@changePassword');
    
    // Category Route
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/view-categories', 'CategoryController@viewCategories');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::post('/admin/update-category-status','CategoryController@updateStatus');

    // Product Route
    Route::match(['get', 'post'], '/admin/add-product', 'ProductsController@addProduct');
    Route::match(['get', 'post'], '/admin/view-products', 'ProductsController@viewProducts');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::match(['get', 'post'], '/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    Route::post('/admin/update-product-status','ProductsController@updateStatus');
    Route::post('/admin/update-featured-product-status','ProductsController@updateFeatured');


    //Product Attributes
    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductsController@addAttributes');
    Route::match(['get', 'post'], '/admin/delete-attributes/{id}', 'ProductsController@deleteAttributes');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}', 'ProductsController@editAttributes');
    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductsController@addImages');
    Route::match(['get', 'post'], '/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImages');

    // Banner Route
    Route::match(['get', 'post'], '/admin/banners', 'BannersController@banners');
    Route::match(['get', 'post'], '/admin/add-banner', 'BannersController@addBanner');
    Route::match(['get', 'post'], '/admin/edit-banner/{id}', 'BannersController@editBanner');
    Route::match(['get', 'post'], '/admin/delete-banner/{id}', 'BannersController@deleteBanner');
    Route::post('/admin/update-banner-status','BannersController@updateStatus');

    // Coupons Route
    Route::match(['get', 'post'], '/admin/add-coupon', 'couponsController@addCoupon');
    Route::match(['get', 'post'], '/admin/view-coupons', 'couponsController@viewCoupons');
    Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'couponsController@editCoupon');
    Route::match(['get', 'post'], '/admin/delete-coupon/{id}', 'couponsController@deleteCoupon');
    Route::post('/admin/update-coupon-status','couponsController@updateStatus');

    Route::get('/admin/orders','ProductsController@viewOrders');
    Route::get('/admin/orders/{id}','ProductsController@viewOrderDetails');
    Route::get('/admin/order-invoice/{id}','ProductsController@orderInvoice');

    Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');

    Route::get('/admin/customers','ProductsController@viewCustomers');
    Route::post('/admin/update-customer-status','ProductsController@updateCustomerStatus');
    Route::get('/admin/delete-customer/{id}', 'ProductsController@deleteCustome');



});

Route::get('/logout', 'AdminController@logout'); 

