@extends('user.app')

@section('title','Profile')
@section('extra_header')

<style>
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #ff9801;
    }

    li.nav-item a {
        color: #fe9900;
    }

    button.btn.btn-link {
        color: #f79301;
    }

    input#submit:disabled {
        opacity: 0.5;
    }

    input#submit {
        opacity: 1;
    }

    .list-group-item.active {
        background-color: #ff9801;
        border-color: #fa9501;
    }
</style>
@endsection


@section('main_content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>{{ auth()->user()->shop->name}}</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('index') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="#">{{ auth()->user()->shop->name}}</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<div class="container">
    <div class="row my-5">

        <div class="col-md-2 mb-3">
            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="oreders-tab" data-toggle="tab" href="#orders" role="tab"
                        aria-controls="orders" aria-selected="true">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Account Details</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="shop-tab" data-toggle="tab" href="#shop" role="tab" aria-controls="shop"
                        aria-selected="false">Shop Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                        aria-controls="contact" aria-selected="false">Change password</a>
                </li>
            </ul>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-10">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="oreders-tab">
                    <h2>Orders</h2>
                    <order-component />
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h2>Profile</h2>
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" placeholder="Name" class="form-control"
                                        value="{{ auth()->user()->name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" placeholder="email" class="form-control"
                                        value="{{ auth()->user()->email }}" disabled>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                    <h2>Shop Info</h2>
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" placeholder="Name" class="form-control"
                                        value="{{ auth()->user()->shop->name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" placeholder="email" class="form-control"
                                        value="{{ auth()->user()->shop->email }}" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="trade_lic">Trade License:</label>
                                    <input type="text" name="trade_lic" id="trade_lic" placeholder="trade_lic"
                                        class="form-control" value="{{ auth()->user()->shop->trade_license }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="website_url">Website Url:</label>
                                    <input type="text" name="website_url" id="website_url" placeholder="website_url"
                                        class="form-control" value="{{ auth()->user()->shop->website_url }}" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="phone">Phone:</label>
                                    <input type="text" name="phone" id="phone" placeholder="phone" class="form-control"
                                        value="{{ auth()->user()->shop->phone }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="addr_1">Address Line 1:</label>
                                    <input type="text" name="addr_1" id="addr_1" placeholder="addr_1"
                                        class="form-control" value="{{ auth()->user()->shop->addr_1 }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="addr_2">Address Line 2:</label>
                                    <input type="text" name="addr_2" id="addr_2" placeholder="addr_2"
                                        class="form-control" value="{{ auth()->user()->shop->addr_2 }}" disabled>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h2>Change Password</h2>
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div id="customMessage" class=" col-12 mx-auto"></div>
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="old_password">Old Password:</label>
                                    <input type="password" name="old_password" id="old_password"
                                        placeholder="Old password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password:</label>
                                    <input type="password" name="new_password" id="new_password"
                                        placeholder="New password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_pass">Retype New Password:</label>
                                    <input type="password" name="confirm_pass" id="confirm_pass"
                                        placeholder="Retype new password" class="form-control" required>
                                </div>
                                <input style="font-size: 16px;" type="submit" class="genric-btn primary text-uppercase"
                                    value="Change password" id="submit" disabled="">
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_footer')
<script type="text/javascript">
    $(document).ready(function(){
		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});
		$("#new_password, #confirm_pass").on('keyup paste',function(){
			var old_password = $("#old_password").val();
			var new_password = $("#new_password").val();
			var confirm_pass = $("#confirm_pass").val();
			//console.log(old_password);
			//console.log(new_password.length);
			if(new_password.length <=8 ){
				$("#customMessage").html('<div class="alert alert-info">New password must be at least 8 character</div>');
			}else if(new_password == old_password){
				$("#customMessage").html('<div class="alert alert-info">New password can not be same as old password</div>');
			}else {
				$("#customMessage").html('<div class="alert alert-info">Proceed to next.</div>');
			}
		});

		$("#confirm_pass").on('keyup paste',function(){
			var old_password = $("#old_password").val();
			var new_password = $("#new_password").val();
			var confirm_pass = $("#confirm_pass").val();
			if(confirm_pass != ""){
				if(!(new_password == confirm_pass)){
					$("#customMessage").html('<div class="alert alert-info">New passwords do not match</div>');
				}else{
					$("#customMessage").html('<div class="alert alert-info">You are good to go.</div>');
					$("input[type='submit']").removeAttr('disabled');
				}
			}
		});



		//$("form").submit(function(e){
		$("#submit").on('click',function(e){
		        e.preventDefault();
		        console.log('prevented');
	        	var old_password = $("#old_password").val();
	        	var new_password = $("#new_password").val();
	        	var confirm_pass = $("#confirm_pass").val();
	        	var  _token = $('input[name="_token"]').val();


	        	$.ajax({
	        		url: "{{ route('custonpasschange') }}",
	        		type: 'post',
	        		data: {old_password:old_password,_token:_token,new_password:new_password},
	        		success: function(data){
	        			console.log(data);
                        if(data.success == 'false'){
                            $("#customMessage").html('<div class="alert alert-danger">'+ data.message +'</div>');

                        }else{
                            $("#customMessage").html('<div class="alert alert-success">'+ data.message +'</div>');
                        }

	        			if(data.success == 'true'){
		        			$.ajax
				                ({
				                    type: 'POST',
				                    url: '/logout',
				                    success: function()
				                    {
				                        location.reload();
				                    }
				                });
				        }
	        		}
	        	});
	        	
		  });



	});

</script>



@endsection