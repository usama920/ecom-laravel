@extends('admin.layouts.master')
@section('title','Add Category')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-users"></i>
        </div>
        <div class="header-title">
            <h1>Add Category</h1>
            <small>Add Category</small>
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
                            <a class="btn btn-add " href="{{url('/admin/view-categories')}}">
                                <i class="fa fa-eye"></i>View Categories</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/add-category')}}" method="POST">
                        @csrf
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" class="form-control" placeholder="Enter Category Name" name="category_name" required>
                            </div>
                            <div class="form-group">
                                <label>Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="0">Parent Category</option>
                                    @foreach($levels as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>URL</label>
                                <input type="text" class="form-control" placeholder="Enter URL" name="category_url" id="category_url" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="category_description" id="category_description" class="form-control"></textarea>
                            </div>
                            
                            <div class="reset-button">
                                <input type="submit" name="" id="" value="Add Category" class="btn btn-success">
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