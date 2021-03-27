<?php

namespace App\Http\Controllers;

use App\Banners;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $banners=Banners::where(['status'=>1])->orderBy('sort_order','asc')->get();
        return view('wayshop.index')->with(compact('banners'));
    }
}
