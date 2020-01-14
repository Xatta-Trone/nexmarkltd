@extends('admin.app')

@section('page_title','Edit order settings')
@section('extra_css')

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin_asset/bower_components/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: #000;
    }
</style>
@endsection


@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Settings
        <a href="{{ route('orders.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Settings</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="orderform" enctype="multipart/form-data" role="form" method="POST"
            action="{{ route('order.setting.update') }}">

            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label for="company_name">company_name</label>
                    <input type="text" class="form-control" name="company_name" id="company_name"
                        placeholder="company_name" value="{{ $settings->company_name }}" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter  phone"
                        value="{{ $settings->phone }}" required>
                </div>

                <div class="form-group">
                    <label for="address">company address</label>
                    <input type="text" class="form-control" name="address" id="address"
                        placeholder="Enter company address" value="{{ $settings->address }}" required>
                </div>

                <div class="form-group">
                    <label for="email">company email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter company email"
                        value="{{ $settings->email }}" required>
                </div>

                <div class="form-group">
                    <label for="shipping_charge">company shipping_charge</label>
                    <input type="number" step="0.01" class="form-control" name="shipping_charge" id="shipping_charge"
                        placeholder="Enter company shipping_charge" value="{{ $settings->shipping_charge }}" required>
                </div>

                <div class="form-group">
                    <label for="logo">current logo</label>
                    <img src="{{ asset('/storage/settings/'.$settings->logo) }}" alt="">
                </div>

                <div class="form-group">
                    <label for="logo">company logo</label>
                    <input type="file" class="form-control" name="logo" id="logo" placeholder="Enter company logo">
                </div>
            </div>




    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary"
            {{-- onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....';" --}}>Update</button>
        <a href="{{ route('orders.index') }}" class="btn btn-danger">cancel</a>
    </div>
    </form>
    </div>
    <!-- /.box -->



</section>
<!-- /.content -->

@endsection




@section('extra_js')
<!-- Select2 -->
<script src=" {{ asset('admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

<script>
    $(function () {

    //Initialize Select2 Elements
    // $('.select2').select2({
    //         placeholder: "Select a shop"}
    // )
    //     //Initialize Select2 Elements
    //     $('.select2.products').select2({
    //         placeholder: "Select a product"
    //     }
    // );

    // $(document).on('click', '.delete', function(){  
       
    //     console.log($(this).closest('row').remove());
    //   });  

  })

</script>




<script defer type="text/javascript">




</script>


@endsection