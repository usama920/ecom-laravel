@extends('wayshop.layouts.master')

@section('content')

<div class="cart-box-main">
    <div class="container">
    <h1 align="center">User Orders</h1><br><br>
        <div class="row">
            <div class="col-lg-12">
                <div align="center">
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderDetails->orders as $pro)
                            <tr>
                                <td>{{$pro->product_code}}</td>
                                <td>{{$pro->product_name}}</td>
                                <td>{{$pro->product_size}}</td>
                                <td>{{$pro->product_color}}</td>
                                <td>{{$pro->product_price}}</td>
                                <td>{{$pro->product_qty}}</td>
                                <td>{{$orderDetails->order_status}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

<?php
session()->forget('order_id');
session()->forget('grand_total');
?>
