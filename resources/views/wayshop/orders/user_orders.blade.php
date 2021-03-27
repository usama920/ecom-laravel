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
                                <th>Order ID</th>
                                <th>Ordered Product</th>
                                <th>Payment Method</th>
                                <th>Grand Total</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>
                                    @foreach($order->orders as $pro)
                                    <a href="{{url('/orders/'.$order->id)}}">
                                        {{$pro->product_code}}
                                        ({{$pro->product_qty}})
                                    </a><br>
                                    @endforeach
                                </td>
                                <td>{{$order->payment_method}}</td>
                                <td>{{$order->grand_total}}</td>
                                <td>{{$order->created_at}}</td>
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
