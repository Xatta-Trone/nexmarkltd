@extends('admin.app')

@section('page_title','Roles')

@section('extra_css')
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('admin_asset/bower_components/font-awesome/css/font-awesome.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('admin_asset/bower_components/Ionicons/css/ionicons.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet"
    href="{{ asset('admin_asset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Roles
        <a href="{{ route('roles.create') }}" class="btn btn-success pull-right ">Add New</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')


    <div class="box">
        <div class="box-header">
            <h3 class="box-title">roles</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>AddedOn</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>AddedOn</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@endsection

@section('extra_js')


<!-- DataTables -->
<script src="{{ asset('admin_asset/bower_components/datatables.net/js/jquery.dataTables.min.js')}}">
</script>
<script src="{{ asset('admin_asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('admin_asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>


<script>
    $(function () {
      $('#example1').DataTable({
        serverSide: true,
         processing: true,
         ajax: '{{ route('roles.ajax') }}', 
         columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'created_at', name: 'created_at' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, "desc" ]]
      })
      
    })
</script>

@endsection