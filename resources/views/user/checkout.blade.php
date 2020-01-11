@extends('user.app')

@section('title','Checkout')
@section('extra_header')

<style>
    .register-form-business {
        overflow-x: hidden;
    }
</style>
@endsection


@section('main_content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Checkout</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

{{-- checkout area --}}

<div class="container">
    <form action="{{ route('createOrder') }}" method="POST" class="needs-validation" style="color: black;" novalidate>
        <div class="row py-5">
            <div class="col-12 col-md-6  mx-auto">
                <h4 class="text-uppercase">Shipping details</h4>
                @csrf
                <input type="hidden" name="shop_id" value="{{auth()->user()->shop_id}}">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input class="form-control" type="text" name="name" id="name" required
                        value="{{ trim(auth()->user()->name) }}">
                    <div class="invalid-feedback bg-danger text-white p-1">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="shipping_address">Shipping Address:</label>
                    <textarea name="shipping_address" required id="shipping_address" class="form-control" cols="30"
                        rows="5">{{ auth()->user()->shop->addr_1 }} {{ auth()->user()->shop->addr_2 }}</textarea>
                    <div class="invalid-feedback bg-danger text-white p-1">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input class="form-control" type="text" name="phone" id="phone" required
                        value="{{ trim(auth()->user()->shop->phone) }}">
                    <div class="invalid-feedback bg-danger text-white p-1">Please fill out this field.</div>
                </div>
                <h4 class="text-uppercase">Billing Details</h4>

                <span class="">Payment Method</span>
                <div class="form-check">
                    <label class="form-check-label">
                        <input required type="radio" value="bkash" class="form-check-input" name="trx_type">Bkash
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" required value="rocket" class="form-check-input" name="trx_type">Rocket

                        <div class="invalid-feedback bg-danger text-white p-2">Please select payment method</div>

                    </label>
                </div>
                <span class="p-2 my-2 d-block bg-primary font-weight-normal text-white">You will be redirected to
                    respective
                    payment option page
                    based on your
                    selection</span>


                <div class="form-group">
                    <label for="note">Extra Note (optional):</label>
                    <textarea name="note" id="note" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <button type="submit" style="font-size: 20px" class="text-uppercase genric-btn primary">Place
                    order</button>


                <a href="{{ route('cart') }}" style="font-size: 16px"
                    class="text-uppercase genric-btn info pull-right">goto Cart</a>

            </div>
        </div>

    </form>
</div>
{{-- checkout area --}}


@endsection

@section('extra_footer')
<script>
    (function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();



</script>



@endsection