@extends('wayshop.layouts.master')

@section('content')

<div class="contact-box-main">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="contact-form-right">
                    <h2>Change Address...</h2>
                    <form action="{{url('/change-address')}}" method="POST" id="contactForm registerForm">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name" id="name"
                                        name="name" required data-error="Please Enter Your Name" value="{{$userDetails->name}}">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Address" id="address"
                                        name="address" required data-error="Please Enter Your Address" value="{{$userDetails->address}}">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your City" id="city"
                                        name="city" required data-error="Please Enter Your City" value="{{$userDetails->city}}">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your State" id="state"
                                        name="state" required data-error="Please Enter Your State" value="{{$userDetails->state}}">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="country" id="country" class="form-control">
                                        <option value="1">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->country_name}}" @if($country->country_name== $userDetails->country) selected @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Pincode"
                                        id="pincode" name="pincode" required data-error="Please Enter Your Pincode" value="{{$userDetails->pincode}}">
                                    <div class="help-block with-errors">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Mobile Number"
                                        id="mobile" name="mobile" required data-error="Please Enter Your Mobile Number" value="{{$userDetails->mobile}}">
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