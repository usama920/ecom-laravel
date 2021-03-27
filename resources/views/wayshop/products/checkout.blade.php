@extends('wayshop.layouts.master')

@section('content')

<div class="contact-box-main">
    <div class="container">
        <form action="{{url('/checkout')}}" method="POST" id="contactForm registerForm">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="contact-form-right">
                        <h2>Bill To</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing Name" id="billing_name"
                                        name="billing_name" value="{{$userDetails->name}}" required
                                        data-error="Please Enter Your Name">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing Address" required
                                        data-error="Please Enter Your Name" id="billing_address" name="billing_address"
                                        value="{{$userDetails->address}}">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing City" required
                                        data-error="Please Enter Your Name" id="billing_city" name="billing_city"
                                        value="{{$userDetails->city}}">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing State" required
                                        data-error="Please Enter Your Name" id="billing_state" name="billing_state"
                                        value="{{$userDetails->state}}">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="billing_country" id="billing_country" class="form-control">
                                        <option value="1">Select Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->country_name}}" @if($country->country_name==
                                            $userDetails->country) selected @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing Pincode" required
                                        data-error="Please Enter Your Name" id="billing_pincode" name="billing_pincode"
                                        value="{{$userDetails->pincode}}">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Billing Mobile" required
                                        data-error="Please Enter Your Name" id="billing_mobile" name="billing_mobile"
                                        value="{{$userDetails->mobile}}">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" style="margin-left: 30px;">
                                    <input type="checkbox" class="form-check-input" name="" id="billtoship">
                                    <label for="billtoship" class="form-check-label">Shipping Address Same As Billing
                                        Address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="contact-form-right">
                        <h2>Ship To</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping Name"
                                        id="shipping_name" name="shipping_name" required
                                        data-error="Please Enter Your Name" @if(!empty($shippingDetails->name)) ?  value="{{$shippingDetails->name}} @endif">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping Address" required
                                        data-error="Please Enter Your Name" id="shipping_address"
                                        name="shipping_address" @if(!empty($shippingDetails->address)) ? value="{{$shippingDetails->address}}" @endif>
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping City" required
                                        data-error="Please Enter Your Name" id="shipping_city" name="shipping_city" @if(!empty($shippingDetails->city)) ? value="{{$shippingDetails->city}}" @endif>
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping State" required
                                        data-error="Please Enter Your Name" id="shipping_state" @if(!empty($shippingDetails->name)) ? value="{{$shippingDetails->state}}" @endif name="shipping_state">
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="shipping_country" id="shipping_country" class="form-control">
                                        <option value="1">Select Country</option>
                                        @foreach($countries as $country)
                                        <option @if(!empty($shippingDetails->name)) ? value="{{$shippingDetails->country}}" @if($country->country_name==
                                            $shippingDetails->country) selected @endif @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping Pincode" required
                                        data-error="Please Enter Your Name" id="shipping_pincode"
                                        name="shipping_pincode" @if(!empty($shippingDetails->pincode)) ? value="{{$shippingDetails->pincode}}" @endif>
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Shipping Mobile" required
                                        data-error="Please Enter Your Name" id="shipping_mobile" name="shipping_mobile" @if(!empty($shippingDetails->mobile)) ? value="{{$shippingDetails->mobile}}" @endif>
                                    <div class="help-block with-errors">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button text-center">
                                    <button class="btn hvr-hover" id="submit" type="submit">Checkout</button>
                                    <div class="h3 text-center hidden" id="msgSubmit"></div>
                                    <div class="clearFix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</form>
</div>
</div>

@endsection