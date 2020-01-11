@extends('user.app')

@section('title','Thank You')
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
                <h1>Thank You</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Thank You</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row py-2">
        <div class="col-6 mx-auto">
            <h4>We have received your order</h4>
            <h4>Your order ID is <span class="bg-primary p-2 text-white">{{ $order_details->id }}</span>
                .</span></h4>
            <h4>Your order Status is <span class="bg-primary p-2 text-white">{{ $order_details->status }}</span>
                .</span></h4>
            <h4>We will shortly reach to you after verification of payment</h4>

            <a href="{{ route('index') }}" class="text-uppercase genric-btn primary mt-1">Home</a>




        </div>
    </div>
</div>


{{-- cart table --}}


@endsection

@section('extra_footer')
<script>




</script>




@endsection