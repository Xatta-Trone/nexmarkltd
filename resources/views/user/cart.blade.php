@extends('user.app')

@section('title','Cart')
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
                <h1>Cart</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Cart</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

{{-- cart table --}}
<user-cart />


{{-- cart table --}}


@endsection

@section('extra_footer')
<script>




</script>




@endsection