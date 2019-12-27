@extends('admin.app')

@section('page_title','Add')

@section('extra_css')

@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Permission
        <a href="{{ route('permissions.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Permission</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('permissions.store') }}">

            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Permission Name">
                </div>

                <div class="form-group">
                    <label>Permission for</label>
                    <select class="form-control" name="for_w">
                        <option value="">Permission for</option>
                        <option value="admin">Admin</option>
                        <option value="category">Category</option>
                        <option value="permission">Permission</option>
                        <option value="role">Role</option>
                        <option value="shop">Shop</option>
                    </select>
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