@extends('wayshop.layouts.master')

@section('content')

<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-12">
                <div class="contact-form-right">
                    <h2>New User SignUp !</h2>
                    <form action="{{url('/user-register')}}" method="POST" id="contactForm registerForm">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name" id="name"
                                        name="name" required data-error="Please Enter Your Name">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Email" id="email"
                                        name="email" required data-error="Please Enter Your Email">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Your Password"
                                        id="password" name="password" required data-error="Please Enter Your Password">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" id="submit" type="submit">Signup</button>
                                    <div class="h3 text-center hidden" id="msgSubmit"></div>
                                    <div class="clearFix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-1 col-sm-12" id="or">
                OR
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="contact-form-right">
                    <h2>Already a member ? Just SignIn !</h2>
                    <form action="{{url('/user-login')}}" id="contactForm LoginForm" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Email" id="email"
                                        name="email" required data-error="Please Enter Your Email">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Your Password"
                                        id="password" name="password" required data-error="Please Enter Your Password">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" id="submit" type="submit">SignIn</button>
                                    <div class="h3 text-center hidden" id="msgSubmit"></div>
                                    <div class="clearFix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection