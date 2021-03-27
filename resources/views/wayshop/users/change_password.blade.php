@extends('wayshop.layouts.master')

@section('content')

<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="contact-form-right">
                    <h2>Change Password...</h2>
                    <form action="{{url('/change-password')}}" method="POST" id="contactForm registerForm">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" placeholder="Your Password" id="old_pwd"
                                        name="old_pwd" required data-error="Please Enter Your Password">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Your Old Password"
                                        id="current_password" name="current_password" required data-error="Please Enter Your Password">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Your New Password"
                                        id="new_pwd" name="new_pwd" required data-error="Please Enter Your Password">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" id="submit" type="submit">Save</button>
                                    <div class="h3 text-center hidden" id="msgSubmit"></div>
                                    <div class="clearFix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

@endsection