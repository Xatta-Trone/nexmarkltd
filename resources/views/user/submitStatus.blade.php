@extends('user.app')

@section('title','Status')
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
                <h1>Status</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Status</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="register-form-business">

    <div class="row">
        <div class="col-12 col-md-8 mx-auto text-center py-5">
            {{-- @include('includes.messages') --}}
            <p class="h2 text-warning text-uppercase">Thank You</p>
            <p class="h5">{{ session('message') }}</p>
            <p>You will get notification after suceesful verification</p>


        </div>
    </div>


</section>
@endsection

@section('extra_footer')

@endsection