@extends('admin.layouts.master')
@section('title','View Categories')
@section('content')


<div id="message_success" style="display: none;" class="alert alert-sm alert-success"><span style="margin-left: 50%;">Status Enabled</span></div>
<div id="message_error" style="display: none;" class="alert alert-sm alert-danger"><span style="margin-left: 50%;">Status Disabled</span></div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="header-icon">
                  <i class="fa fa-eye"></i>
               </div>
               <div class="header-title">
                  <h1>View Categories</h1>
                  <small>Categories List</small>
               </div>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                           <div class="btn-group" id="buttonexport">
                              <a href="#">
                                 <h4>View Categories</h4>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                        <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <div class="btn-group">
                              <div class="buttonexport" id="buttonlist"> 
                                 <a class="btn btn-add" href="{{url('/admin/add-category')}}"> <i class="fa fa-plus"></i> Add Category
                                 </a>  
                              </div>
                           </div>
                           <!-- Plugin content:powerpoint,txt,pdf,png,word,xl -->
                           <div class="table-responsive">
                              <table id="table_id" class="table table-bordered table-striped table-hover">
                                 <thead>
                                    <tr class="info">
                                       <th>ID</th>
                                       <th>Category Name</th>
                                       <th>Parent ID</th>
                                       <th>URL</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 @foreach($categories as $category)
                                    <tr>
                                       <td>{{$category->id}}</td>
                                       <td>{{$category->name}}</td>
                                       <td>{{$category->parent_id}}</td>
                                       <td>{{$category->url}}</td>
                                       <td>
                                           <input type="checkbox" class="CategoryStatus btn btn-success" rel="{{$category->id}}" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger"
                                           @if($category->status=="1") checked @endif>
                                           <div id="myElem" style="display: none;" class="alert alert-success">Status Enabled</div>
                                       </td>
                                       <td>
                                          <a href="{{url('/admin/edit-category/'.$category->id)}}" class="btn btn-add btn-sm" ><i class="fa fa-pencil"></i></a>
                                          <a href="{{url('/admin/delete-category/'.$category->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> </a>
                                       </td>
                                    </tr>
                                    @endforeach
                                 
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->

@endsection