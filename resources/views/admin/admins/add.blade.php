@extends('admin.app')

@section('page_title','Add')

@section('extra_css')

@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Admins
        <a href="{{ route('admins.index') }}" class="btn btn-success pull-right ">List</a>

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
            <h3 class="box-title">Add New Admin</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('admins.store') }}">

            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Admin Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Admin Name"
                        autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                    <span id="email_message"></span>
                </div>

                <div class="form-group">
                    <label for="">Assign Roles</label> <br>
                    @foreach ($roles as $role)
                    <label><input type="checkbox" name="role[]" class="flat-red" value="{{ $role->id }}">
                        {{ $role->name }} </label>
                    @endforeach
                </div>



                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>

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




<script>
    $("#email").on('keyup paste',function(){
      var email = $('#email').val();
        var _token = $('input[name="_token"]').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!filter.test(email))
        {    
         $('#email_message').html('<label class="text-danger">Invalid Email</label>');
         //$('#email').addClass('has-error');
         //$("input[type='submit']").attr('disabled', 'disabled');
        }else{
          //console.log(email);
          //console.log(_token);
          $.ajax({
              url:"{{ route('admins.checkemail') }}",
              method:"POST",
              data:{email:email, _token:_token},
              success:function(result)
              {
                console.log(result);
               if(result > 0)
               {
                $('#email_message').html('<label class="text-danger">Email already exists</label>');
                //$('#email').removeClass('has-error');
                //$('#register').attr('disabled', false);
               }
               else
               {
                $('#email_message').html('<label class="text-success">Email Available</label>');
                //$('#email').addClass('has-error');
                //$("input[type='submit']").removeAttr("disabled");
               }
              }
             })
            }
        });

</script>


@endsection