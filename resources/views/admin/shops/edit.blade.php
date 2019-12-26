@extends('admin.app')

@section('page_title','Edit')

@section('extra_css')

@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Shops
        <a href="{{ route('shops.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>
    {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol> --}}
</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Update</h3>
            <small class="label label-danger">all * marked fields are required</small>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('shops.update',$shop->id) }}" enctype="multipart/form-data">

            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Shop Name*</label>
                    <input required type="text" class="form-control" name="name" id="name" placeholder="Enter shop name"
                        value="{{ $shop->name }}">
                </div>

                <div class="form-group">
                    <label for="trade_license">Trade License No*</label>
                    <input required value="{{ $shop->trade_license }}" type="text" class="form-control"
                        name="trade_license" id="trade_license" placeholder="Enter Trade License No">
                </div>

                <div class="form-group">
                    <label for="website_url">Website URL*</label>
                    <input required value="{{ $shop->website_url }}" type="text" class="form-control" name="website_url"
                        id="website_url" placeholder="Enter Website URL">
                </div>

                <div class="form-group">
                    <label for="email">Shop Business email*</label>
                    <input required value="{{ $shop->email }}" type="email" class="form-control" name="email" id="email"
                        placeholder="Enter Shop Business email">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number*</label>
                    <input required value="{{ $shop->phone }}" type="phone" class="form-control" name="phone" id="phone"
                        placeholder="Enter Shop Business phone" maxlength="11">
                </div>

                <div class="form-group">
                    <label for="addr_1">Address Line 1*</label>
                    <input required value="{{ $shop->addr_1 }}" type="text" class="form-control" name="addr_1"
                        id="addr_1" placeholder="Enter Shop Business address line 1">
                </div>

                <div class="form-group">
                    <label for="addr_2">Address Line 2</label>
                    <input type="text" class="form-control" name="addr_2" id="addr_2"
                        placeholder="Enter Shop Business address line 2" value="{{ $shop->addr_2 }}">
                </div>

                <div class="form-group">
                    <label for="trade_license_file">Trade License file (pdf or image) max file size 5MB*</label>
                    <input type="file" class="form-control" name="trade_license_file"
                        accept="application/pdf,image/jpg,image/png,image/jpeg" id="trade_license_file">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{ $shop->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $shop->status == 0 ? 'selected' : '' }}>Inactive</option>

                    </select>
                </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button required type="submit" class="btn btn-primary"
                    {{-- onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....'; " --}}>Submit</button>
            </div>
        </form>
    </div>
    <!-- /.box -->



</section>
<!-- /.content -->

@endsection

@section('extra_js')

{{-- <!-- InputMask -->
<script src="{{ asset('admin_asset/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('admin_asset/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('admin_asset/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script> --}}


<script>



</script>


@endsection