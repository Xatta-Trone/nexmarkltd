@extends('admin.app')

@section('page_title','Add')

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
        Products
        <a href="{{ route('products.index') }}" class="btn btn-success pull-right ">List</a>

    </h1>

</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Add New</h3>
            <small class="label label-danger">all * marked fields are required</small>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('products.excell.import') }}" enctype="multipart/form-data">

            @csrf
            <div class="box-body">


                <div class="form-group">
                    <label for="image">Products excell</label>
                    <input type="file" class="form-control" name="products" id="image">
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
<!-- CK Editor -->
<script src="{{ asset('admin_asset/bower_components/ckeditor/ckeditor.js')}}"></script>
<!-- Select2 -->
<script src="{{ asset('admin_asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>



<script>
    $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //Initialize Select2 Elements
    $('.select2').select2()
    //bootstrap WYSIHTML5 - text editor
    // $('.textarea').wysihtml5()
  })

</script>

<script>
    $("#name").on('keyup paste',function(){
      var product_name = $('#name').val();
        var _token = $('input[name="_token"]').val();

          $.ajax({
              url:"{{ route('products.check') }}",
              method:"POST",
              data:{product_name:product_name, _token:_token},
              success:function(result)
              {
                console.log(result);
               if(result > 0)
               {
                $('#name_message').html('<label class="text-danger">product already exists with same name</label>');

               }
               else
               {
                $('#name_message').html('');

               }
              }
             })
            
        });

</script>


@endsection