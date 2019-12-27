@extends('admin.app')

@section('page_title','Edit')

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
            <h3 class="box-title">Edit Permission</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('permissions.update',$permission->id) }}">

            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Permission Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Permission Name"
                        value="{{ $permission->name }}">
                </div>

                <div class="form-group">
                    <label>Permission for</label>
                    <select class="form-control" name="for_w">
                        <option value="">Permission for</option>
                        <option value="admin" {{ ($permission->for_w == 'admin') ? 'selected': '' }}>Admin</option>
                        <option value="category" {{ ($permission->for_w == 'category') ? 'selected': '' }}>Category
                        </option>
                        <option value="permission" {{ ($permission->for_w == 'admin') ? 'permission': '' }}>Permission
                        </option>
                        <option value="role" {{ ($permission->for_w == 'role') ? 'selected': '' }}>Role</option>
                        <option value="shop" {{ ($permission->for_w == 'shop') ? 'selected': '' }}>Shop</option>
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