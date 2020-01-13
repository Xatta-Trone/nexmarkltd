@extends('admin.app')

@section('page_title','Edit order #'.$order->id)
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
        Edit Order
        <a href="{{ route('orders.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit order #{{ $order->id }}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="orderform" role="form" method="POST" action="{{ route('orders.update',$order->id) }}">

            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="name"
                        value="{{ $order->name }}" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter  phone"
                        value="{{ $order->phone }}" required>
                </div>

                <div class="form-group">
                    <label for="shipping_address">shipping_address</label>
                    <input type="text" class="form-control" name="shipping_address" id="shipping_address"
                        placeholder="Enter  shipping_address" value="{{ $order->shipping_address }}" required>
                </div>
                <div class="form-group">
                    <label>Trx Type</label>
                    <select class="form-control" name="trx_type">
                        <option value="rocket" {{ $order->trx_type == 'rocket' ? 'selected' :''}}>rocket
                        </option>
                        <option value="bkash" {{ $order->trx_type == 'bkash' ? 'selected' :''}}>bkash</option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="trx_id">trx_id</label>
                    <input type="text" class="form-control" name="trx_id" id="trx_id" placeholder="Enter  trx_id"
                        value="{{ $order->trx_id }}" required>
                </div>

                <div class="form-group">
                    <label for="note">note</label>
                    <input type="text" class="form-control" name="note" id="note" placeholder="Enter  note"
                        value="{{ $order->note }}">
                </div>

                <ul class="list-group">
                    <li class="list-group-item active">Items (Taka. {{ $order->total_amount }})</li>


                    @foreach ($order->items as $item)
                    <li class="list-group-item ">{{ json_decode($item)->name  }} <strong>Qty.</strong>
                        {{ json_decode($item)->qty  }}
                        <strong> Price.</strong> {{ json_decode($item)->price  }}
                    </li>
                    @endforeach
                </ul>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"
                    {{-- onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....';" --}}>Submit</button>
                <a href="{{ route('orders.index') }}" class="btn btn-danger">canel</a>
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