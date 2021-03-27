@extends('admin.layouts.master')
@section('title','User Profile')
@section('content')




<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-eye"></i>
        </div>
        <div class="header-title">
            <h1>User Profile</h1>
            <small>Profile</small>
        </div>
    </section>
    <!-- Main content -->
    
    <section class="content">
        <div class="row">
            <!-- Form controls -->
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    
                    <div class="panel-body">
                        <form class="col-sm-6" action="{{url('/admin/user-profile')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" class="form-control" id="old_pwd" name="old_pwd" required>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" id="current_pwd" name="current_pwd" required>

                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_pwd" id="new_pwd" required>
                            </div>
                           
                            
                            <div class="reset-button">
                                <input type="submit" name="" id="" value="Add Product" class="btn btn-success">
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