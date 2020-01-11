@extends('user.app')

@section('title','Bkash')
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
                <h1>Bkash</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Bkash</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row py-2">
        <div class="col-6 mx-auto">
            <h4>how to Send Money</h4>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i> Go
                to your bKash Mobile Menu by
                dialing *247#</span>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i>
                Choose “Send Money”</span>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i>
                Enter the bKash Account Number you want to send money to.</span>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i>
                Enter the amount of taka <span
                    class="bg-primary p-2 text-white">{{ $order_details->total_amount }}</span>
                .</span>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i>
                Enter a reference number <span class="bg-primary p-2 text-white">{{ $order_details->id }}</span></span>
            <span class="p-2 my-2 d-block  font-weight-normal "><i class="fa fa-arrow-right" aria-hidden="true"></i> Now
                enter your bKash Mobile Menu PIN to confirm the transaction.</span>

            <form action="{{ route('payment.make') }}" method="POST">
                <div class="form-group">
                    @csrf
                    <label for="trx_id">Enter Trx Id:</label>
                    <input name="trx_id" required id="trx_id" class="form-control" />
                    <input type="hidden" name="trx_type" value="bkash">
                    <input type="hidden" name="id" value="{{ $order_details->id  }}">
                    <button type="submit" style="font-size: 20px"
                        class="text-uppercase genric-btn primary mt-1">Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>


{{-- cart table --}}


@endsection

@section('extra_footer')
<script>




</script>




@endsection