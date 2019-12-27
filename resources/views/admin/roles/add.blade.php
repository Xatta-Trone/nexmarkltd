@extends('admin.app')

@section('page_title','Add')

@section('extra_css')

@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Role
        <a href="{{ route('roles.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New role</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('roles.store') }}">

            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name">role Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter role Name">
                </div>

                <div class="form-group">
                    @foreach ($distinct_permissions as $distinct_permission)
                    <div class="col-md-6">
                        <label>{{ ucfirst($distinct_permission['for_w']) }} Permission</label>
                        @foreach ($permissions as $permission)
                        @if ($permission->for_w == $distinct_permission['for_w'])
                        <div><label><input type="checkbox" name="permission[]" class="flat-red"
                                    value="{{ $permission->id }}"> {{ $permission->name }}</label></div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach


                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"
                    onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....'; ">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.box -->



</section>
<!-- /.content -->

@endsection

@section('extra_js')







@endsection