@extends('wayshop.layouts.master')

@section('content')

<div class="cart-box-main">
    <div class="container">
    <h1 align="center">Thanks for purchasing with us!</h1><br><br>
        <div class="row">
            <div class="col-lg-12">
                <div align="center">
                    <h2>Your COD order has been placed</h2>
                    <p>Your Order Number is {{Session('order_id')}} and total payable amount is {{Session('grand_total')}}</p>
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
