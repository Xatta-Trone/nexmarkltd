@extends('user.app')

@section('title','Business Register')
@section('extra_header')

<style>
    .register-form-business {
        overflow-x: hidden;
    }
</style>
@endsection


@section('main_content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Register Shop</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Register Shop</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<section class="register-form-business">

    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            @include('includes.messages')

            <!-- Default form register -->
            <form method="POST" enctype="multipart/form-data" class="text-left border border-light p-5 needs-validation"
                action="{{ route('shop.submit') }}" novalidate>
                @csrf

                <p class="h4 mb-4">Register your shop here</p>
                <p>Please fill all the fields</p>

                <div class="form-row mb-4">
                    <!--Name-->
                    <input type="text" id="name" name="name" class="form-control " placeholder="Shop Name" required
                        value="{{ old('name') }}">
                    <div class="invalid-feedback">
                        Enter Shop Name
                    </div>
                </div>

                <div class="form-row mb-4">
                    <input type="email" id="email" class="form-control " placeholder="E-mail address" required
                        name="email" value="{{ old('email') }}">
                    <div class="invalid-feedback">
                        Enter valid email
                    </div>
                </div>

                <div class="form-row mb-4">
                    <div class="col">
                        <!-- First name -->
                        <input type="text" id="trade_license" class="form-control" placeholder="Trade license Number"
                            name="trade_license" required value="{{ old('trade_license') }}">
                        <div class="invalid-feedback">
                            Enter Trade license number
                        </div>
                        <span id="trade_license_message"></span>

                    </div>
                    <div class="col">
                        <!-- Last name -->
                        <input type="url" id="website_url" class="form-control" placeholder="Shop website/fb url"
                            name="website_url" required value="{{ old('website_url') }}">
                        <div class="invalid-feedback">
                            Enter website/fb url
                        </div>

                    </div>
                </div>


                <div class="form-row mb-2">
                    <input type="text" id="phone" class="form-control" placeholder="Phone number" required name="phone"
                        value="{{ old('phone') }}">
                    <div class="invalid-feedback">
                        Enter valid phone number
                    </div>
                    <small class="form-text text-primary">
                        OTP codes will be sent to this phone number
                    </small>
                </div>

                <div class="form-row mb-4">
                    <!-- Password -->
                    <input type="text" id="addr_1" class="form-control " placeholder="Address Line 1" required
                        name="addr_1" value="{{ old('addr_1') }}">
                    <div class="invalid-feedback">
                        Enter shop address
                    </div>
                </div>
                <div class="form-row mb-4">
                    <input type="text" id="addr_2" class="form-control " placeholder="Address Line 2" name="addr_2"
                        value="{{ old('addr_2') }}">
                </div>
                <div class="form-row mb-4">
                    <label for="trade_license_file" class="form-text  mb-2 text-primary">Trade License file (pdf or
                        image)
                        max file size 5MB</label>

                    <input type="file" id="trade_license_file" class="form-control mb-4"
                        placeholder="Trade license file" required
                        accept="application/pdf,image/jpg,image/png,image/jpeg" name="trade_license_file">
                    <div class="invalid-feedback">
                        Enter valid file
                    </div>
                </div>

                <!-- Terms of service -->
                <p>By clicking
                    <em>Sign up</em> you agree to our
                    <a href="" target="_blank">terms of service</a>


                    <!-- Sign up button -->
                    <button class="btn btn-info my-4 btn-block" type="submit">Sign Up</button>

                    <p>Already have an account <a href="{{ route('login') }}" class="mx-auto " role="button"> Sign
                            In</a>
                    </p>



                    <hr>



            </form>
            <!-- Default form register -->
        </div>
    </div>


</section>
@endsection

@section('extra_footer')
<script>
    (function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();



</script>



<script>
    $("#trade_license").on('keyup paste',function(){
      var trade_license = $('#trade_license').val().trim();
        var _token = $('input[name="_token"]').val();

          $.ajax({
              url:"{{ route('shop.validatetradelicense') }}",
              method:"POST",
              data:{trade_license:trade_license, _token:_token},
              success:function(result)
              {
                console.log(result);
               if(result > 0)
               {
                $('#trade_license_message').html('<label class="text-danger">A shop already exists with this trade license</label>');
               }
               else
               {
                $('#trade_license_message').html('<label class="text-success"></label>');
               }
              }
             })
            
        });

</script>
@endsection