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
                <h1>Login</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">Login</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{ asset('user_asset/img/login.jpg') }}" alt="">
                    <div class="hover">
                        <h4>New to our website?</h4>
                        <p>Request to create an account for your shop from the link below</p>
                        <a class="primary-btn" href="{{ route('register') }}">Create an Account</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Log in to enter</h3>
                    <form class="row login_form" method="POST" action="{{ route('login') }}" id="contactForm"
                        novalidate="novalidate">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="enter your Email" onfocus="this.placeholder = ''"
                                onblur="this.placeholder = 'enter your Email'" value="{{ old('email') }}" required
                                autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password"
                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="f-option2">Keep me logged in</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Log In</button>
                            @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->
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