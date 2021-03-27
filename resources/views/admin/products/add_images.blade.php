@extends('admin.layouts.master')
@section('title','Product Attributes')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Add Product Images</h1>
            <small>Add Product Images</small>
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
                            <a class="btn btn-add " href="{{url('/admin/view-products')}}">
                                <i class="fa fa-eye"></i>View Attributes</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/add-images/'.$productDetails->id)}}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                            <div class="form-group">
                                <label>Product Name</label>{{$productDetails->name}}
                            </div>
                            <div class="form-group">
                                <label>Product Code</label>{{$productDetails->code}}
                            </div>
                            <div class="form-group">
                                <label>Product Color</label>{{$productDetails->color}}
                            </div>
                            <div class="form-group">
                                <label>Images</label>
                                <input type="file" name="image[]" id="image" multiple="multiple">
                            </div>
                            <div class="reset-button">
                                <input type="submit" name="" id="" value="Add Product Attributes" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- Show Images -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonexport">
                            <a href="#">
                                <h4>View Images</h4>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                        <div class="btn-group">
                            <div class="buttonexport" id="buttonlist">
                                <a class="btn btn-add" href="{{url('/admin/add-product')}}"> <i class="fa fa-plus"></i>
                                    Add Attrubutes
                                </a>
                            </div>

                        </div>
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                        <div class="table-responsive">
                            <table id="table_id" class="table table-bordered table-striped table-hover">
                                <form action="{{url('/admin/edit-images/'.$productDetails->id)}}"
                                    enctype="multipart/form-data" method="POST">
                                    {{csrf_field()}}
                                    <thead>
                                        <tr class="info">
                                            <th>ID</th>
                                            <th>Product ID</th>
                                            <th>Image</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productImages as $productImage)
                                        <tr>
                                            <td>{{$productImage->id}}</td>
                                            <td>{{$productImage->product_id}}</td>
                                            <td><img src="{{asset('uploads/products/'.$productImage->image)}}" style="width: 80px;"></td>
                                           
                                            <td class="center">
                                                <div class="btn-group">
                                                    <a href="{{url('/admin/delete-alt-image/'.$productImage->id)}}"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- View Images -->

</div>
<!-- /.content-wrapper -->
@endsection