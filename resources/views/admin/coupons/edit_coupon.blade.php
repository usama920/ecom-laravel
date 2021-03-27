@extends('admin.layouts.master')
@section('title','Add Coupon')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Edit Coupons</h1>
            <small>Edit Coupons</small>
        </div>
    </section>
    <!-- Main content -->
    <div class="message_success" style="display: none;" class="alert alert-success">Status Enabled</div>
    <div class="message_success" style="display: none;" class="alert alert-danger">Status Disabled</div>

    <section class="content">
        <div class="row">
            <!-- Form controls -->
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonlist">
                            <a class="btn btn-add " href="{{url('/admin/view-coupons')}}">
                                <i class="fa fa-eye"></i>View Coupons</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/edit-coupon/'.$couponDetails->id)}}" method="POST" enctype="multipart/form-data" name="edit_coupon" id="edit_coupon">
                        @csrf
                            <div class="form-group">
                                <label>Coupon Code</label>
                                <input type="text" name="coupon_code" class="form-control" id="coupon_code" value="{{$couponDetails->coupon_code}}">
                            </div>
                            <div class="form-group">
                                <label>Coupon Amount</label>
                                <input type="text" class="form-control" value="{{$couponDetails->amount}}" name="coupon_amount" id="coupon_amount" required>
                            </div>
                            <div class="form-group">
                                <label>Amount Type</label>
                                <select name="amount_type" id="amount_type" class="form-control">
                                    <option @if($couponDetails->amount_type=="Percentage") selected @endif value="Percentage">Percentage</option>
                                    <option @if($couponDetails->amount_type=="Fixed") selected @endif value="Fixed">Fixed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" value="{{$couponDetails->expiry_date}}" class="form-control" name="expiry_date" id="datepicker" required>
                            </div>
                            <div class="reset-button">
                                <input type="submit"  value="Add Coupon" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection