@extends('wayshop.layouts.master')

@section('content')

<div class="cart-box-main">
    <div class="container">
        <h1 align="center">Thanks for purchasing with us!</h1><br><br>
        <div class="row">
            <div class="col-lg-6">
                <div align="center">
                    <h2>Your COD order has been placed</h2>
                    <p>Your Order Number is {{Session('order_id')}} and total payable amount is
                        {{Session('grand_total')}}</p>
                    <b>Please Make payment by entering credit or debit card</b>
                </div>
            </div>
            <div class="col-lg-6">
                <script src="https://js.stripe.com/v3/"></script>

                <form action="/stripe" method="post" id="payment-form">
                @csrf
                    <div class="form-row">
                        <b>Total Amount</b>
                        <input readonly name="total_amount" value="{{Session('grand_total')}}" class="form-control">
                        <b>Your Name</b>
                        <input type="text" name="name" placeholder="Enter Your Name" class="form-control">
                        <b>Card Number</b>
                        <div class="form-control" id="card-element"></div>
                    </div>

                    <button class="btn btn-success btn-mini" style="float: right; margin-top:10px;">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Create a Stripe client.
var stripe = Stripe(
    'pk_test_51HrIs7FtvvCwpQsaLUnLOU5WBT9HLwh8b3gg0mKCAmXRi7eH1qbG21DtbbsVmd8TfdF7sQSHenYKTCmaNweyrK2C00idGk6dCZ');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {
    style: style
});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
@endsection

<?php
session()->forget('order_id');
session()->forget('grand_total');
?>