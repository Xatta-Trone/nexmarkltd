@extends('admin.app')

@section('page_title','Categories')

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
        Categories
        <a href="{{ route('categories.create') }}" class="btn btn-success pull-right ">Add New</a>

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
            <h3 class="box-title">Categories</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>AddedOn</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    {{-- @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>

                    <td>
                        <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-primary"><i
                                class="fa fa-pencil"></i></a>

                        <a href="#"
                            onclick="if(confirm('are you sure ?')){ event.preventDefault(); document.getElementById('delete-form-{{$category->id}}').submit();}else{event.preventDefault();}"
                            class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <form id="delete-form-{{$category->id}}"
                            action="{{ route('categories.destroy',$category->id) }}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                        </form>


                    </td>

                    </tr>
                    @endforeach --}}

                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
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
         ajax: '{{ route('categories.ajax') }}', 
         columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'slug', name: 'slug' },
          { data: 'status', name: 'status' },
          { data: 'created_at', name: 'created_at' },
          {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        "order": [[ 0, "desc" ]]
      })
      
    })
</script>

@endsection