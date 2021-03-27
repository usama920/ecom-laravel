@extends('admin.layouts.master')
@section('title','Edit Product')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Edit Product</h1>
            <small>Edit Product</small>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Form controls -->
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonlist">
                            <a class="btn btn-add " href="{{url('/admin/view-products')}}">
                                <i class="fa fa-eye"></i>View Products</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/edit-product/'.$productDetails->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" value="{{$productDetails->name}}" placeholder="Enter Prodcut Name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <?php echo $categories_dropdown; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Code</label>
                                <input type="text" class="form-control" value="{{$productDetails->code}}" placeholder="Enter Product Code" name="product_code" id="product_code" required>
                            </div>
                            <div class="form-group">
                                <label>Product Color</label>
                                <input type="text" class="form-control" value="{{$productDetails->color}}" placeholder="Enter Product Color" name="product_color" id="product_color" required>
                            </div>
                            <div class="form-group">
                                <label>Product Description</label>
                                <textarea name="product_description" id="product_description" class="form-control">{{$productDetails->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="text" class="form-control" value="{{$productDetails->price}}" placeholder="Enter Product Price" name="product_price" id="product_price" required>
                            </div>
                            <div class="form-group">
                                <label>Picture upload</label>
                                <input type="file" name="image">
                                <input type="hidden" name="current_image" value="{{$productDetails->image}}">
                                @if(!empty($productDetails->image))
                                <img src="{{asset('uploads/products/'.$productDetails->image)}}" style="width: 100px;">
                                @endif
                            </div>
                            <div class="reset-button">
                                <input type="submit" name="" id="" value="Edit Product" class="btn btn-success">
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