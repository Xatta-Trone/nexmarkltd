@extends('admin.app')

@section('page_title','Shops')

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
        Shops
        <a href="{{ route('shops.create') }}" class="btn btn-success pull-right ">Add New</a>

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


    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Shops</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Trd Lic</th>
                        <th>Website</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Approved By</th>
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
                        <th>Trd Lic</th>
                        <th>Website</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Approved By</th>
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
         ajax: '{{ route('shops.ajax') }}', 
         columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'trade_license', name: 'trade_license' },
          { data: 'website_url', name: 'website_url' },
          { data: 'email', name: 'email' },
          { data: 'phone', name: 'phone' },
          { data: 'addr_1', name: 'addr_1' },
          { data: 'status', name: 'status' },
          { data: 'approved_by', name: 'approved_by' },
          { data: 'created_at', name: 'created_at' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, "desc" ]],
        "scrollX": true 
      })
      
    })
</script>

@endsection