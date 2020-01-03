@extends('admin.app')

@section('page_title','Products')

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
        products
        <a href="{{ route('products.create') }}" class="btn btn-success pull-right ">Add New</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')


    <div class="box">
        <div class="box-header">
            <h3 class="box-title">products</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>AddedBy</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>AddedBy</th>
                        <th>Status</th>
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


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

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
         ajax: '{{ route('products.ajax') }}', 
         columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'price', name: 'price' },
          { data: 'image', name: 'image' },
          { data: 'admin_id', name: 'admin_id' },
          { data: 'status', name: 'status' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, "desc" ]]
      });



      $(document).on('click','#productViewModal', function() {
      //e.preventDefault();
      var id = $(this).data('id');
      var _token = $('input[name="_token"]').val();
      console.log(id);
      console.log(_token);

      $.ajax({
        url: '{{route('products.getSingleProduct')}}',
        type: 'POST',
        data: {id:id,_token:_token},
        dataType:'json',
        success: function(data){
          console.log(data);
        //   $('.modal-title').html(data.name);
        //   $('#dept_batch').html(data.dept_batch);
        //   $('#body').html(data.message);
          $('#myModal').modal('show');
        }
      });
    });
      
    })
</script>

@endsection