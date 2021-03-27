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
            <h1>Add Product Attributes</h1>
            <small>Add Product Attributes</small>
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
                                <i class="fa fa-eye"></i>View Products</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/add-attributes/'.$productDetails->id)}}"
                            method="POST">
                            @csrf
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
                                <div class="field_wrapper">
                                    <div style="display: flex;">
                                        <input type="text" name="sku[]" id="sku" placeholder="SKU" class="form-control"
                                            style="width:120px; margin-right:5px; margin-top:5px;" />
                                        <input type="text" name="size[]" id="size" placeholder="Size"
                                            class="form-control"
                                            style="width:120px; margin-right:5px; margin-top:5px;" />
                                        <input type="text" name="price[]" id="price" placeholder="Price"
                                            class="form-control"
                                            style="width:120px; margin-right:5px; margin-top:5px;" />
                                        <input type="text" name="stock[]" id="stock" placeholder="Stock"
                                            class="form-control"
                                            style="width:120px; margin-right:5px; margin-top:5px;" />
                                        <a href="javascript:void(0)" class="add_button" title="Add Field">Add</a>
                                    </div>
                                </div>
                            </div>
                            <div class="reset-button">
                                <input type="submit" name="" id="" value="Add Product Attributes"
                                    class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- View Attributes -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="btn-group" id="buttonexport">
                            <a href="#">
                                <h4>View Products</h4>
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
                                <form action="{{url('/admin/edit-attributes/'.$productDetails->id)}}"
                                    enctype="multipart/form-data" method="POST">
                                    {{csrf_field()}}
                                    <thead>
                                        <tr class="info">
                                            <th>Catgeory ID</th>
                                            <th>SKU</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productDetails['attributes'] as $attribute)
                                        <tr>
                                            <td style="display: none;">
                                                <input type="hidden" name="attr[]"
                                                    value="{{$attribute->id}}">{{$attribute->id}}
                                            </td>
                                            <td>{{$attribute->id}}</td>
                                            <td>
                                                <input type="text" name="sku[]" value="{{$attribute->sku}}">
                                            </td>
                                            <td>
                                                <input type="text" name="size[]" value="{{$attribute->size}}">
                                            </td>
                                            <td>
                                                <input type="text" name="price[]" value="{{$attribute->price}}">
                                            </td>
                                            <td>
                                                <input type="text" name="stock[]" value="{{$attribute->stock}}">
                                            </td>
                                            <td class="center">
                                                <div class="btn-group">
                                                    <input type="submit" value="update" class="btn btn-success" style="height: 30px; padding-top:4px;">
                                                    <a href="{{url('/admin/delete-attributes/'.$attribute->id)}}"
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
    <!-- End Attributes -->
</div>
<!-- /.content-wrapper -->
@endsection